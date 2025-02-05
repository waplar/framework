<?php

namespace Artist\Poet;

use Illuminate\Support\Str;

class ConsoleOutput extends \Symfony\Component\Console\Output\ConsoleOutput
{

    /**
     * @param  iterable|string  $messages
     * @param  int              $options
     */
    public function writeln(iterable|string $messages, int $options = 0): void
    {
        $messages = $this->build($messages);

        parent::writeln($messages, $options);
    }

    /**
     * @param  string  $message
     *
     * @return string
     */
    private function build(string $message): string
    {
        return Str::of($message)->explode("\n")->map(function (string $line) {
            return Str::repeat(' ', 1) . $line;
        })->implode("\n");
    }

    /**
     * @param  string|iterable  $messages
     * @param  bool             $newline
     * @param  int              $options
     */
    public function write(string|iterable $messages, bool $newline = false, int $options = 0): void
    {
        parent::write($messages, $newline, $options);
    }

}
