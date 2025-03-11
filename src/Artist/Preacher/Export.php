<?php

namespace Artist\Preacher;

use Closure;
use Illuminate\Http;
use Illuminate\Support\Facades\Response;

readonly class Export
{

    /**
     * Construct derived instance
     *
     * @param array $data
     */
    public function __construct(private array $data = [])
    {
        // ...
    }

    /**
     * Export in json format
     *
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return Http\JsonResponse
     */
    public function json(
        int $status = Constants\DefaultSetting::HTTP_STATUS,
        array $headers = [],
        int $options = Constants\DefaultSetting::JSON_OPTIONS
    ): Http\JsonResponse {
        return Response::json(self::array(), $status, $headers, $options);
    }

    /**
     * Array format export
     *
     * @return array
     */
    public function array(): array
    {
        return $this->data;
    }

    /**
     * Custom making export
     *
     * @param Closure $content
     * @param int     $status
     * @param array   $headers
     *
     * @return Http\Response
     */
    public function make(
        Closure $content,
        int $status = Constants\DefaultSetting::HTTP_STATUS,
        array $headers = []
    ): Http\Response {
        return Response::make(
            $content(self::array()),
            $status,
            $headers
        );
    }

    /**
     * Export in jsonp format
     *
     * @param string|null $callback
     * @param int         $status
     * @param array       $headers
     * @param int         $options
     *
     * @return Http\JsonResponse
     */
    public function jsonp(
        string|null $callback = null,
        int $status = Constants\DefaultSetting::HTTP_STATUS,
        array $headers = [],
        int $options = Constants\DefaultSetting::JSON_OPTIONS
    ): Http\JsonResponse {
        return Response::jsonp(
            $callback,
            self::array(),
            $status,
            $headers,
            $options
        );
    }

}
