<?php

namespace Illustrator\Preacher\Constants;

class HttpStatus
{

    /**
     * Successful status code
     *
     * @var int
     */
    public const SUCCEED = 200;

    /**
     * Failed status code
     *
     * @var int
     */
    public const FAILED = 500;

    /**
     * No status code found
     *
     * @var int
     */
    public const NOT_FOUND = 404;

    /**
     * Status code of the failed request
     *
     * @var int
     */
    public const BAD_REQUEST = 400;

    /**
     * The status code returned when unauthorized
     *
     * @var int
     */
    public const UNAUTHORIZED = 401;

    /**
     * Forbidden status code (usually used in maintenance mode)
     *
     * @var int
     */
    public const FORBIDDEN = 403;

    /**
     * The status code returned when the request method does not allow it
     *
     * @var int
     */
    public const METHOD_NOT_ALLOWED = 405;

}
