<?php

if (!function_exists('artist_path')) {
    /**
     * Illustrator 目录地址
     * The artist's dir path
     *
     * @param string $path
     *
     * @return string
     */
    function artist_path(string $path = ''): string
    {
        return base_path('artist' . ($path ? '/' . $path : ''));
    }
}

if (!function_exists('waiter_path')) {
    /**
     * Waiter 目录地址
     * The waiter's dir path
     *
     * @param string $path
     *
     * @return string
     */
    function waiter_path(string $path = ''): string
    {
        return artist_path('waiter' . ($path ? '/' . $path : ''));
    }
}
