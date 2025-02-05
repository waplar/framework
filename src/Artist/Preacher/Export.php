<?php

namespace Artist\Preacher;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response as ResponseFactory;

/**
 * Export preacher response
 *
 * @author KanekiYuto
 */
readonly class Export
{

    /**
     * Construct derived instance
     *
     * @param array $data
     */
    public function __construct(private array $data = [])
    {
        // Do it...
    }

    /**
     * Export as json
     *
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return JsonResponse
     */
    public function json(
        int $status = Response\DefaultSetting::HTTP_STATUS,
        array $headers = [],
        int $options = Response\DefaultSetting::JSON_OPTIONS
    ): JsonResponse {
        return ResponseFactory::json(self::array(), $status, $headers, $options);
    }

    /**
     * Export the data in array format
     *
     * @return array
     */
    public function array(): array
    {
        return $this->data;
    }

    /**
     * Export as jsonp
     *
     * @param string|null $callback
     * @param int         $status
     * @param array       $headers
     * @param int         $options
     *
     * @return JsonResponse
     */
    public function jsonp(
        string|null $callback = null,
        int $status = Response\DefaultSetting::HTTP_STATUS,
        array $headers = [],
        int $options = Response\DefaultSetting::JSON_OPTIONS
    ): JsonResponse {
        return ResponseFactory::jsonp(
            $callback,
            self::array(),
            $status,
            $headers,
            $options
        );
    }

}
