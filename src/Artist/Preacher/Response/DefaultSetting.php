<?php

namespace Artist\Preacher\Response;

class DefaultSetting
{

    /**
     * Default service status code key name
     *
     * @var string
     */
    public const KEY_CODE = 'code';

    /**
     * Default service status code key name
     *
     * @var string
     */
    public const KEY_STATUS = 'status';

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
    public const HTTP_STATUS = 200;

    /**
     * Default JSON option
     *
     * @var int
     */
    public const JSON_OPTIONS = JSON_UNESCAPED_UNICODE;

}
