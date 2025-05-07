<?php

namespace Illustrator\Preacher;

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
     * @param int    $statusCode
     *
     * @return Builder
     */
    public static function basic(
        string $msg = Constants\DefaultSetting::MSG,
        int $statusCode = Constants\DefaultSetting::STATUS_CODE
    ): Builder {
        return new Builder(
            hook: self::getHook(),
            msg: $msg,
            statusCode: $statusCode
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
     * @param int   $pages
     * @param int   $total
     * @param array $rows
     *
     * @return Builder
     */
    public static function paging(int $page, int $pages, int $total, array $rows): Builder
    {
        return (new Builder(hook: self::getHook()))->setPaging(
            page: $page,
            pages: $pages,
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
