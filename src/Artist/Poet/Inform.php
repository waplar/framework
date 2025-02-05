<?php

namespace Artist\Poet;

use Illuminate\Support\Str;

trait Inform
{

    /**
     * @param  string  $message
     * @param  array   $emphasize
     * @param  bool    $tag
     */
    public function warn(string $message, array $emphasize = [], bool $tag = true): void
    {
        $this->build(__FUNCTION__, $message, $tag, $emphasize);
    }

    /**
     * @param  string  $fn
     * @param  string  $message
     * @param  bool    $tag
     * @param  array   $emphasize
     */
    public function build(string $fn, string $message, bool $tag, array $emphasize): void
    {
        $this->emphasize = $emphasize;
        $styles = $this->styles[$fn];

        $message = $tag ? [
            $this->statusTag($styles, $fn),
            $this->statusMessage($styles, $message),
        ] : [$this->message($styles, $message)];

        $this->output->writeln('');
        $this->output->writeln(implode(' ', $message), true);
    }

    /**
     * @param  array   $styles
     * @param  string  $content
     *
     * @return string
     */
    private function statusTag(array $styles, string $content): string
    {
        return $this->style($styles['status']['tag'], ' ' . Str::upper($content) . ' ');
    }

    /**
     * @param  array   $styles
     * @param  string  $content
     *
     * @return string
     */
    private function statusMessage(array $styles, string $content): string
    {
        return $this->style($styles['status']['message'], $content);
    }

    /**
     * @param  array   $styles
     * @param  string  $content
     *
     * @return string
     */
    private function message(array $styles, string $content): string
    {
        return $this->style($styles['message'], $content);
    }

    /**
     * @param  string  $message
     * @param  array   $emphasize
     * @param  bool    $tag
     */
    public function fail(string $message, array $emphasize = [], bool $tag = true): void
    {
        $this->build(__FUNCTION__, $message, $tag, $emphasize);
    }

    /**
     * @param  string  $message
     * @param  array   $emphasize
     * @param  bool    $tag
     */
    public function note(string $message, array $emphasize = [], bool $tag = true): void
    {
        $this->build(__FUNCTION__, $message, $tag, $emphasize);
    }

    /**
     * @param  string  $message
     * @param  array   $emphasize
     * @param  bool    $tag
     */
    public function succeed(string $message, array $emphasize = [], bool $tag = true): void
    {
        $this->build(__FUNCTION__, $message, $tag, $emphasize);
    }

}
