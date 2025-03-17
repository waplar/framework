<?php

namespace Illustrator\Waiter\Console;

use Closure;
use Illuminate\Console\Command;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illustrator\Support\Console\Trait\ConfirmableTrait;
use Illustrator\Support\Facades\Poet;
use Illustrator\Waiter\Scheduler;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command as CommandAlias;

#[AsCommand(name: 'waplar:waiter')]
class WaiterCommand extends Command
{

    use ConfirmableTrait;

    /**
     * Command name
     *
     * @var string
     */
    protected $signature = 'waplar:waiter {pattern=all : Which mode to select the file in}';

    /**
     * Command description
     *
     * @var string
     */
    protected $description = 'Run the waiter.';

    /**
     * The directory to execute the files
     *
     * @var string
     */
    protected string $directory;

    /**
     * Support's patterns
     *
     * @var array
     */
    private array $patterns = ['all', 'select', 'multiselect'];

    /**
     * Create a new console command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->directory = waiter_path();
    }

    /**
     * Execute artisan command
     *
     * @return int
     */
    public function handle(): int
    {
        $pipes = [];
        $pattern = $this->argument('pattern');

        // 验证参数值是否有效
        // Verify that the parameter value is valid
        $pipes[] = function (array $params, Closure $next) {
            [$code, $pattern] = $params;

            if (!in_array($pattern, $this->patterns)) {
                $emphasizes = collect($this->patterns)->mapWithKeys(function ($value) {
                    $key = ":$value";
                    $value = Poet::text($value, [
                        'color' => Poet::color('warn'),
                    ]);

                    return [$key => $value];
                });

                Poet::warn(
                    'The pattern must be one of [' . $emphasizes->keys()->implode(', ') . ']!',
                    $emphasizes->all()
                );

                return CommandAlias::FAILURE;
            }

            return $next([$code, $pattern]);
        };

        // 根据模式分派对应的处理逻辑
        // Dispatch the corresponding processing logic according to the pattern
        $pipes[] = function (array $params, Closure $next) {
            [$code, $pattern] = $params;

            $paths = match ($pattern) {
                'select' => [
                    select(
                        label: 'Select the file you want to execute!',
                        options: $this->getFilesOption()
                    ),
                ],
                'multiselect' => multiselect(
                    label: 'Select the files you want to execute!',
                    options: $this->getFilesOption(),
                    hint: 'Press the space bar to select the desired option.'
                ),
                default => array_keys($this->getFilesOption())
            };

            if (empty($paths)) {
                Poet::warn('There are no files to execute!');

                return CommandAlias::FAILURE;
            }

            return $next([$code, $paths]);
        };

        // 输出执行信息到控制台
        // Output execution information to the console
        $pipes[] = function (array $params, Closure $next) {
            [$code, $paths] = $params;

            Poet::content(implode(' ', [
                __METHOD__,
                __LINE__,
            ]), implode("\n", [
                'Start executing the build...',
                'Files directory: :directory',
            ]), [
                ':directory' => Poet::text(Str::replace('/', '\\', "$this->directory"), [
                    'color' => Poet::color('note'),
                    'underline' => true,
                    'bold' => true,
                ]),
            ]);

            return $next([$code, $paths]);
        };

        // 派发给调度器
        // Send to the scheduler
        $pipes[] = Scheduler::class;

        return app(Pipeline::class)
            ->send([CommandAlias::SUCCESS, $pattern])
            ->through($pipes)
            ->then(function ($params) {
                return $params[0];
            });
    }

    /**
     * Get option file information
     *
     * @return array
     */
    public function getFilesOption(): array
    {
        $result = collect($this->getFiles())->map(function ($path) {
            $value = explode('.', $path)[0];
            $key = $this->directory . DIRECTORY_SEPARATOR . $path;

            return [$key => $value];
        });

        return $result->flatMap(function (array $values) {
            return $values;
        })->all();
    }

    /**
     * Get all files
     *
     * @return array
     */
    protected function getFiles(): array
    {
        return Storage::build([
            'driver' => 'local',
            'root' => $this->directory,
        ])->files();
    }

}
