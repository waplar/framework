<?php

namespace Illustrator\Waiter\Builders;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nette\PhpGenerator\Dumper;
use PhpCsFixer\Config;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

class Builder
{

    /**
     * 数组转换为代码文本
     * The array is converted to code text
     *
     * @param array $values
     *
     * @return string
     */
    final protected function arrayToCode(array $values): string
    {
        return (new Dumper())->dump($values);
    }

    /**
     * 存根文件磁盘
     * Stub file disk
     *
     * @param string|null $path
     *
     * @return Filesystem
     */
    final protected function stubDisk(?string $path = null): Filesystem
    {
        $path = $path ? DIRECTORY_SEPARATOR . $path : '';

        return Storage::build([
            'driver' => 'local',
            'root' => implode(DIRECTORY_SEPARATOR, [
                dirname(__DIR__, 4),
                'stubs' . $path,
            ]),
        ]);
    }

    /**
     * 批量设置参数
     * Set parameters in batches
     *
     * @param array  $params
     * @param string $stub
     *
     * @return string
     */
    final protected function params(array $params, string $stub): string
    {
        foreach ($params as $param => $value) {
            $stub = $this->param($param, $value, $stub);
        }

        return $stub;
    }

    /**
     * 设置参数值
     * Set parameter value
     *
     * @param string      $param
     * @param string|bool $value
     * @param string      $stub
     *
     * @return string
     */
    final protected function param(string $param, string|bool $value, string $stub): string
    {
        $value = match (gettype($value)) {
            'boolean' => $value ? 'true' : 'false',
            default => $value
        };

        return Str::of($stub)->replace("{{ $param }}", $value)->toString();
    }

    /**
     * 将代码格式化为可读的
     * Format the code to be readable
     *
     * @param string $content
     *
     * @return string
     */
    final protected function format(string $content): string
    {
        // 将需要格式化的代码内容转存到临时文件中
        // Transfer the code content that needs to be formatted to a temporary file
        $file = tempnam(sys_get_temp_dir(), 'php_code') . '.php';
        file_put_contents($file, $content);

        // 配置代码风格规则
        // Configure code style rules
        $config = new Config();
        $config->setRules(config('waplar.waiter.format.rules') ?? [
            '@PSR12' => true,
            'braces' => true,
            'indentation_type' => true,
            'full_opening_tag' => true,
        ]);

        $tokens = Tokens::fromCode(file_get_contents($file));
        $fixerFactory = new FixerFactory();

        $fixerFactory->registerBuiltInFixers();
        $fixers = $fixerFactory->getFixers();

        foreach ($fixers as $fixer) {
            if ($config->getRules()[$fixer->getName()] ?? false) {
                $fixer->fix(new SplFileInfo($file), $tokens);
            }
        }

        // 获取格式化后的代码
        // Get the formatted code
        $formattedCode = $tokens->generateCode();

        unlink($file);

        return $formattedCode;
    }

    /**
     * 导入包信息
     * Import package information
     *
     * @param string $class
     * @param array  $usePackages
     *
     * @return string
     */
    protected function usePackages(string $class, array &$usePackages): string
    {
        $packageAlias = Str::of($class)->explode("\\");
        $packageAlias = $packageAlias->only(
            1,
            $packageAlias->count() - 1,
            $packageAlias->count()
        )->implode('');

        $usePackages[$class] = "use $class as $packageAlias;";

        return $packageAlias;
    }

}
