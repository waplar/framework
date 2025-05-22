<?php

namespace Illustrator\Preacher\Constants;

class DefaultSetting
{

    /**
     * 默认业务代码键名
     * Default service status code key name
     *
     * @var string
     */
    public const KEY_STATUS_CODE = 'code';

    /**
     * 默认消息键名
     * Default message key name
     *
     * @var string
     */
    public const KEY_MESSAGE = 'msg';

    /**
     * 默认回执键名
     * Default receipt key name
     *
     * @var string
     */
    public const KEY_RECEIPT = 'receipt';

    /**
     * 默认分页键名
     * Default paging key name
     *
     * @var string
     */
    public const KEY_PAGING = 'paging';

    /**
     * 默认行键名
     * Default rows key name
     *
     * @var string
     */
    public const KEY_ROWS = 'rows';

    /**
     * 默认数据键名
     * Default data key name
     *
     * @var string
     */
    public const KEY_DATA = 'data';

    /**
     * 默认 HTTP 响应状态码
     * Default http response status code
     *
     * @var int
     */
    public const HTTP_STATUS = HttpStatus::SUCCEED;

    /**
     * 默认 JSON 选项
     * Default JSON option
     *
     * @var int
     */
    public const JSON_OPTIONS = JSON_UNESCAPED_UNICODE;

    /**
     * 默认消息键值
     * Default message key's value
     */
    public const MSG = 'success';

    /**
     * 默认业务代码键值
     * Default status code's value
     */
    public const STATUS_CODE = StatusCode::SUCCEED;

}
