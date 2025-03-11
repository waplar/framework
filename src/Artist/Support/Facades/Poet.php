<?php

namespace Artist\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Poet facade
 *
 * @method static void   content(string $title, string $content, array $emphasize = [])
 * @method static void   note(string $message, array $emphasize = [], bool $tag = true)
 * @method static void   warn(string $message, array $emphasize = [], bool $tag = true)
 * @method static void   fail(string $message, array $emphasize = [], bool $tag = true)
 * @method static void   succeed(string $message, array $emphasize = [], bool $tag = true)
 * @method static string text(string $content, array $styles = [])
 * @method static string color(string $type)
 */
class Poet extends Facade
{

    /**
     * Facade accessor
     *
     * @var string
     */
    public const FACADE_ACCESSOR = 'artist.poet';

    /**
     * Indicates whether the parsed Facade should be cached
     *
     * @var bool
     */
    protected static $cached = false;

    /**
     * Gets the registered name of the component
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return self::FACADE_ACCESSOR;
    }

}
