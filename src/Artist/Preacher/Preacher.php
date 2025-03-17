<?php

namespace Artist\Preacher;

use Closure;
use stdClass;

class Preacher
{

    /**
     * @var Closure
     */
    private static Closure $hook;

    /**
     * @param Closure $callable
     */
    public static function useHook(Closure $callable): void
    {
        self::$hook = $callable;
    }

    /**
     * @param string $msg
     *
     * @return Builder
     */
    public static function basic(string $msg): Builder
    {
        return new Builder(
            hook: self::getHook(),
            msg: $msg
        );
    }

    /**
     * @param array $value
     *
     * @return Builder
     */
    public static function rows(array $value): Builder
    {
        return (new Builder(hook: self::getHook()))->setRows($value);
    }

    /**
     * @param stdClass $value
     *
     * @return Builder
     */
    public static function receipt(stdClass $value): Builder
    {
        return (new Builder(hook: self::getHook()))->setReceipt($value);
    }

    /**
     * @param int   $page
     * @param int   $prePage
     * @param int   $total
     * @param array $rows
     *
     * @return Builder
     */
    public static function paging(int $page, int $prePage, int $total, array $rows): Builder
    {
        return (new Builder(hook: self::getHook()))->setPaging(
            page: $page,
            prePage: $prePage,
            total: $total,
            rows: $rows
        );
    }

    /**
     * @return Closure
     */
    private static function getHook(): Closure
    {
        return self::$hook ?? function (string $msg, array $data) {
            return [$msg, $data];
        };
    }

}
