<?php

namespace Artist\Waiter;

use Artist\Support\Facades\Poet;
use Closure;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Scheduler
{

    /**
     * @var array
     */
    protected array $pipes;

    /**
     * Create a scheduler instance
     */
    public function __construct()
    {
        $this->register();
    }

    /**
     * Handle scheduler
     *
     * @param array $params
     *
     * @return mixed
     */
    public function handle(array $params): mixed
    {
        return app(Pipeline::class)
            ->send($params)
            ->through($this->pipes)
            ->then(function (int $code) {
                return $code;
            });
    }

    /**
     * Registration dependency parameter
     */
    protected function register(): void
    {
        $this->pipes = [];

        App::forgetInstance(Manager::class);
        App::instance(Manager::class, new Manager());

        $this->registerPipes();
    }

    /**
     * Registration pipeline
     */
    protected function registerPipes(): void
    {
        // 读取实例文件并进行验证
        // Read the instance file and validate it
        $this->pipes[] = function (array $params, Closure $next) {
            $instances = [];
            [$code, $paths] = $params;

            foreach ($paths as $path) {
                try {
                    $file = (new Filesystem())->getRequire($path);
                } catch (FileNotFoundException $e) {
                    Poet::fail(':message', [
                        ':message' => Poet::text($e->getMessage(), [
                            'color' => Poet::color('fail'),
                            'underline' => true,
                        ]),
                    ]);

                    return CommandAlias::FAILURE;
                }

                if (!($file instanceof Waiter)) {
                    Poet::fail('Not a correct instance!');

                    return CommandAlias::FAILURE;
                }

                $instances[] = $file;
            }

            return $next([$code, $instances]);
        };

        // 在实例中开启流水线并处理逻辑
        // Open the pipeline and process the logic in the instance
        $this->pipes[] = function (array $params, Closure $next) {
            [$code, $instances] = $params;

            foreach ($instances as $instance) {
                $result = app(Pipeline::class)
                    ->send([$code, $instance])
                    ->through($this->instancePipes())
                    ->then(function ($params) {
                        return $params[0];
                    });

                if ($result === CommandAlias::FAILURE) {
                    return CommandAlias::FAILURE;
                }
            }

            return $next([$code, $instances]);
        };

        // 将存储的存根文件写入到磁盘中
        // Writes the stored stub file to disk
        $this->pipes[] = function () {
            $files = [];
            $stubs = app(Manager::class)->getStubs();
            $stubs = collect($stubs)->sortBy('filepath')->toArray();

            foreach ($stubs as $stub) {
                $filepath = Str::of($stub['filepath'])->explode(DIRECTORY_SEPARATOR);
                $filename = $filepath->pop();
                $shortFilepath = Str::replace(app_path(), '', $stub['filepath']);

                $files[] = Str::replace('\\', '/', $stub['filepath']) . ':0';

                if (!Storage::build([
                    'driver' => 'local',
                    'root' => $filepath->implode(DIRECTORY_SEPARATOR),
                ])->put($filename, $stub['content'])) {
                    $msg = "Description Failed to write the current file. Subsequent write operations are stopped -> [:filepath]";

                    Poet::fail($msg, [
                        ':filepath' => Poet::text($shortFilepath, [
                            'color' => Poet::color('succeed'),
                        ]),
                    ]);

                    return CommandAlias::FAILURE;
                }

                Poet::note("The current file is successfully written -> [:filepath]", [
                    ':filepath' => Poet::text($shortFilepath, [
                        'color' => Poet::color('succeed'),
                    ]),
                ]);
            }

            Poet::content('Files list has been created', implode("\n", $files));

            return CommandAlias::SUCCESS;
        };
    }

    /**
     * Instance pipes
     *
     * @return array
     */
    protected function instancePipes(): array
    {
        return [
            // 验证必须参数是否存在
            // Verify that the required parameter exists
            function (array $params, Closure $next) {
                [$code, $instance] = $params;

                $required = [
                    Constants\Waiter::SCHEMA => 'withSchema',
                    Constants\Waiter::TABLE => 'withTable',
                ];

                if (!$instance->params->has(array_keys($required))) {
                    $emphasizes = collect(array_values($required))->mapWithKeys(function ($value) {
                        $key = ":$value";
                        $value = Poet::text($value, [
                            'color' => Poet::color('warn'),
                        ]);

                        return [$key => $value];
                    });

                    Poet::warn(
                        '[' . $emphasizes->keys()->implode(', ') . '] These methods must be called!',
                        $emphasizes->all()
                    );

                    return CommandAlias::FAILURE;
                }

                return $next([$code, $instance]);
            },

            // 调用闭包并获取返回值
            // Call the closure and get the return value
            function (array $params, Closure $next) {
                [$code, $instance] = $params;

                $withSchema = collect(
                    $instance->params->get(Constants\Waiter::SCHEMA)
                )->map(function (string $closure, string $action) use ($instance) {
                    $closure = unserialize($closure)->getClosure();

                    $schema = new Schema($action, $instance->params->get(Constants\Waiter::TABLE)['name']);

                    $closure($schema);

                    return $schema->getParams();
                });

                $instance->params->set(Constants\Waiter::SCHEMA, $withSchema);

                return $next([$code, $instance]);
            },

            // 根据规则设置命名空间、文件路径、类名
            // Set the namespace, file path, and class name according to the rule
            function (array $params, Closure $next) {
                [$code, $instance] = $params;

                collect([
                    Constants\Waiter::SUMMARY,
                    Constants\Waiter::MODEL,
                ])->map(function (string $key) use ($instance) {
                    $params = $this->resolveOrientedObject(
                        $instance->params->collect($key)->all(),
                        $instance->params->get(Constants\Waiter::CONFIGURE)[$key],
                        $instance->params->get(Constants\Waiter::TABLE)
                    );

                    $instance->params->set($key, $params);
                });

                return $next([$code, $instance]);
            },

            // 调度对应的构建器
            // Schedule the corresponding builder
            function (array $params, Closure $next) {
                [$code, $instance] = $params;

                $pipes = [];
                $builders = [
                    Builders\Summary::class => Constants\Waiter::SUMMARY,
                    Builders\Model::class => Constants\Waiter::MODEL,
                ];

                collect($builders)->map(function (string $key, string $builder) use (&$pipes, $instance) {
                    if ($instance->params->has($key)) {
                        $pipes[] = $builder;
                    }
                });

                app(Pipeline::class)
                    ->send([$instance->params, $builders])
                    ->through($pipes)
                    ->then(function ($params) {
                        return $params;
                    });

                return $next([$code, $instance]);
            },
        ];
    }

    /**
     * @param array $params
     * @param array $configure
     * @param array $table
     *
     * @return array
     */
    private function resolveOrientedObject(array $params, array $configure, array $table): array
    {
        [$classname, $suffixClassname] = $this->resolveClass($params, $configure, $table);
        [$namespace, $fullNamespace] = $this->resolveNamespace($params, $configure, $table);

        $filepath = $this->resolveFilepath($suffixClassname, $namespace, $configure);

        return [
            ...$params,
            'comment' => $params['comment'] ?? $table['comment'],
            'classname' => $suffixClassname,
            'namespace' => $fullNamespace,
            'noSuffixClass' => $classname,
            'filepath' => $filepath,
            'package' => implode("\\", [$fullNamespace, $suffixClassname]),
        ];
    }

    /**
     * @param array $params
     * @param array $configure
     * @param array $table
     *
     * @return array
     */
    private function resolveClass(array $params, array $configure, array $table): array
    {
        $classname = $params['classname'] ?? $table['classname'];

        $suffixClassname = implode('', [
            $classname,
            $configure['suffix']['class'],
        ]);

        return [$classname, $suffixClassname];
    }

    /**
     * @param array $params
     * @param array $configure
     * @param array $table
     *
     * @return array
     */
    private function resolveNamespace(array $params, array $configure, array $table): array
    {
        $namespace = $params['namespace'] ?? $table['namespace'];
        $namespaces[] = $configure['namespace'];

        if (!empty($namespace)) {
            $namespaces[] = $namespace;
        }

        return [$namespace, implode('\\', $namespaces)];
    }

    /**
     * @param string $suffixClassname
     * @param string $namespace
     * @param array  $configure
     *
     * @return string
     */
    private function resolveFilepath(string $suffixClassname, string $namespace, array $configure): string
    {
        $filepath[] = $configure['filepath'];

        if (!empty($namespace)) {
            $filepath[] = $namespace;
        }

        $filepath[] = $suffixClassname . '.' . $configure['suffix']['file'];

        return implode(DIRECTORY_SEPARATOR, $filepath);
    }

}
