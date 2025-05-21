<?php

namespace Illustrator\Preacher\Response;

use Illuminate\Http\JsonResponse as Response;
use Illustrator\Preacher\Builder;

class JsonResponse extends Response
{

    /**
     * 构建一个 Json 响应实例
     * Construct a Json response instance
     *
     * @param  Builder  $builder
     */
    public function __construct(Builder $builder)
    {
        parent::__construct(
            $builder->getData(),
            $builder->getHttpStatus(),
            $builder->getHeaders(),
            $builder->getJsonResponse()['options'],
            $builder->getJsonResponse()['json']
        );
    }

}