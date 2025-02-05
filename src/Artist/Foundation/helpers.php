<?php

if (!function_exists('artist_path')) {
    /**
     * The artist's path
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
     * The waiter's path
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
