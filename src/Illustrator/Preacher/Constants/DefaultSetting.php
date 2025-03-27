<?php

namespace Illustrator\Preacher\Constants;

class DefaultSetting
{

    /**
     * Default service status code key name
     *
     * @var string
     */
    public const KEY_STATUS_CODE = 'code';

    /**
     * Default message key name
     *
     * @var string
     */
    public const KEY_MESSAGE = 'msg';

    /**
     * Default http response status code
     *
     * @var int
     */
    public const HTTP_STATUS = HttpStatus::SUCCEED;

    /**
     * Default JSON option
     *
     * @var int
     */
    public const JSON_OPTIONS = JSON_UNESCAPED_UNICODE;

    /**
     * Default message key's value
     */
    public const MSG = '';

    /**
     * Default status code's value
     */
    public const STATUS_CODE = StatusCode::SUCCEED;

}
