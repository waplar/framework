<?php

namespace Artist\Support\Facades;

use Artist\Preacher\ResponseFactory;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * Preacher facade
 *
 * @method static void            useHook(Closure $closure)
 * @method static ResponseFactory base()
 * @method static ResponseFactory msg(string $msg)
 * @method static ResponseFactory code(int $code)
 * @method static ResponseFactory status(int $status)
 * @method static ResponseFactory decide(int $decide)
 * @method static ResponseFactory msgCode(int $code, string $msg)
 * @method static ResponseFactory paging(int $page, int $prePage, int $total, array $data)
 * @method static ResponseFactory receipt(object $data)
 * @method static ResponseFactory rows(array $data)
 * @method static ResponseFactory allow(bool $allow, mixed $pass, mixed $noPass)
 * @method static ResponseFactory model(Model $model)
 *
 * @author KanekiTuto
 *
 * @see    ResponseFactory
 */
class Preacher extends Facade
{

    /**
     * Facade accessor
     *
     * @var string
     */
    public const FACADE_ACCESSOR = 'artist.preacher';

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
