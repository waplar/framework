<?php

namespace Illustrator\Waiter\Builders;

use Nette\PhpGenerator\Dumper;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpCsFixer\Config;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

class Builder
{

    /**
     * The array is converted to code text
     *
     * @param  array  $values
     *
     * @return string
     */
    final protected function arrayToCode(array $values): string
    {
        return (new Dumper)->dump($values);
    }

    /**
     * The array is converted to code text
     */
    final protected function arrayConvertedToCode(array $values): string
    {
        // 使用 var_export 获取数组的PHP代码形式
        // Use var_export to get the PHP code representation of the array
        $exported = var_export($values, true);

        // 转换为短数组语法
        // Convert to short array syntax
        $exported = preg_replace('/array \(/', '[', $exported);
        $exported = preg_replace('/\)(,?)/m', ']$1', $exported);

        // 保持 ::class 不被误识别为字符串
        // Ensure that ::class is not mistakenly recognized as a string
        $exported = preg_replace_callback('/\'([^\'\\\\]+::class)\'/', function ($matches) {
            // 返回去掉引号的类常量
            // Return the class constant without quotes
            return $matches[1];
        }, $exported);

        // 如果生成的代码长度小于等于 36 字符，直接返回
        // If the generated code is 36 characters or fewer, return it directly
        if (mb_strlen($exported) <= 36) {
            return $exported;
        }

        // 否则移除空格并进行格式调整
        // Otherwise, remove spaces and adjust formatting
        return Str::of($exported)
            ->replace(' ', '')
            ->replace("'=>\n[\n", "'=>[\n")
            ->toString();
    }

    /**
     * Stub file disk
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

    final protected function params(array $params, string $stub): string
    {
        foreach ($params as $param => $value) {
            $stub = $this->param($param, $value, $stub);
        }

        return $stub;
    }

    /**
     * Fill parameter value
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
     * Format the code to be readable
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

}
