<?php

namespace Illustrator\Poet;

use Illuminate\Support\Str;

trait Content
{

    /**
     * @var int
     */
    private int $length = 150;

    /**
     * @param string $title
     * @param string $content
     * @param array  $emphasize
     */
    public function content(string $title, string $content, array $emphasize = []): void
    {
        $this->emphasize = $emphasize;
        $this->output->writeln('');
        $this->output->writeln(implode("\n", [
            $this->header($title),
            $this->body($content),
            $this->footer(),
        ]));
    }

    /**
     * @param string $title
     *
     * @return string
     */
    private function header(string $title): string
    {
        $title = Str::wrap($title, ' ');
        $repeatLength = $this->length - $this->strlen($title) - 2;
        $repeatStr = Str::repeat('─', $repeatLength);

        return implode('', [
            $this->border('┌'),
            $this->style($this->styles['content']['title'], $title),
            $repeatLength > 0 ? $this->border($repeatStr) : '',
            $this->border('┐'),
        ]);
    }

    /**
     * @param string $value
     *
     * @return int
     */
    private function strlen(string $value): int
    {
        $cleanString = preg_replace('/\e\[([0-9;]+)m/', '', $value);

        return mb_strlen($cleanString, 'UTF-8');
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function border(string $value): string
    {
        return $this->style($this->styles['content']['border'], $value);
    }

    /**
     * @param string $content
     *
     * @return string
     */
    private function body(string $content): string
    {
        $length = $this->length - 4;

        $result = Str::of($content)->explode("\n")->map(function (string $value) use ($length) {
            return mb_str_split($value, $length);
        })->flatten();

        return $result->map(function (string $value) use ($length) {
            $value = $this->style($this->styles['content']['content'], $value);
            $repeatLength = $length - $this->strlen($value);
            $repeat = $repeatLength > 0 ? Str::repeat(' ', $repeatLength) : '';

            return implode('', [$this->border('┆'), ' ', $value, $repeat, ' ', $this->border('┆'),]);
        })->implode("\n");
    }

    /**
     * @return string
     */
    private function footer(): string
    {
        return $this->border(implode('', [
            '└',
            Str::repeat('─', $this->length - 2),
            '┘',
        ]));
    }

}
