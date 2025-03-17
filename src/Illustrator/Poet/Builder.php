<?php

namespace Illustrator\Poet;

use Illuminate\Support\Str;
use Symfony\Component\Console\Output\OutputInterface;

class Builder
{

    use Inform, Content;

    /**
     * @var array
     */
    protected array $styles;

    /**
     * @var array
     */
    protected array $config;

    /**
     * @var array
     */
    protected array $emphasize = [];

    /**
     * @var OutputInterface
     */
    protected OutputInterface $output;

    /**
     * @param array $styles
     * @param array $config
     */
    public function __construct(array $styles, array $config)
    {
        $this->styles = $styles;
        $this->config = $config;
        $this->output = new ConsoleOutput();
    }

    /**
     * @param string $content
     * @param array  $styles
     *
     * @return string
     */
    public function text(string $content, array $styles = []): string
    {
        return $this->style($styles, $content);
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function color(string $type): string
    {
        return $this->config[__FUNCTION__][$type] ?? '255,255,255';
    }

    /**
     * @param array  $styles
     * @param string $message
     *
     * @return string
     */
    protected function style(array $styles, string $message): string
    {
        collect($styles)->map(function (string $value, string $key) use (&$style) {
            if (in_array($key, ['backstage', 'color'])) {
                $value = Str::replace(',', ';', $value);
            }

            $style[] = match ($key) {
                'backstage' => "\033[48;2;" . $value . "m",
                'color' => "\033[38;2;" . $value . "m",
                'bold' => $value ? "\033[1m" : '',
                'underline' => $value ? "\033[4m" : '',
                default => ''
            };
        });

        collect($this->emphasize)->map(function (string $value, string $key) use (&$message, $style) {
            $message = Str::replace(
                $key,
                implode('', ["\033[0m", $value, ...$style]),
                $message
            );
        });

        return implode('', [...$style, $message, "\033[0m",]);
    }

}
