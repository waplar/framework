<?php

namespace Illustrator\Preacher\Constants;

class StatusCode
{

    /**
     * 成功响应
     * successful response
     *
     * @var int
     */
    public const SUCCEED = 200;

    /**
     * 客户端请求错误（通用）
     * 用于参数校验失败等业务警告场景
     *
     * Client request error (general)
     * Used for business warning scenarios such as parameter verification failure
     *
     * @var int
     */
    public const WARN = 400;

    /**
     * 服务器内部错误
     * 用于未捕获异常等系统级错误
     *
     * Server internal error
     * For system-level errors such as uncaught exceptions
     *
     * @var int
     */
    public const ERROR = 500;

    /**
     * 资源不存在
     *
     * Resource does not exist
     *
     * @var int
     */
    public const NOT_FOUND = 404;

    /**
     * 未认证
     * 需要登录但未提供有效凭证时返回
     *
     * Not certified
     * Returned when login is required but no valid credentials are provided
     *
     * @var int
     */
    public const UNAUTHORIZED = 401;

    /**
     * 权限不足
     * 已认证但无权访问资源时返回
     *
     * Insufficient permissions
     * Returned when authenticated but not authorized to access the resource
     *
     * @var int
     */
    public const FORBIDDEN = 403;

    /**
     * 请求参数验证失败
     * 适用于表单验证错误（Laravel 422 标准）
     *
     * Request parameter validation failed
     * Applies to form validation errors (Laravel 422 standard)
     *
     * @link https://laravel.com/docs/12.x/validation#validation-error-response-format
     *
     * @var int
     */
    public const VALIDATION_ERROR = 422;

    /**
     * 请求方法不允许
     * 访问路由未定义的方法时返回
     *
     * Request method not allowed
     * Returned when accessing a method that is not defined in the route
     *
     * @var int
     */
    public const METHOD_NOT_ALLOWED = 405;

    /**
     * 服务不可用
     * 通常是维护模式时返回
     *
     * Service unavailable
     * Usually returns when in maintenance mode
     *
     * @link https://laravel.com/docs/12.x/configuration#maintenance-mode
     *
     * @var int
     */
    public const SERVICE_UNAVAILABLE = 503;

    /**
     * URI 太长
     * 请求的 URI 长度超过了服务器的限制
     *
     * URI Too Long
     * The requested URI is too long for the server to process
     *
     * @var int
     */
    public const URI_TOO_LONG = 414;

    /**
     * 依赖失败
     * 由于上游服务器失败，导致请求失败
     *
     * Failed Dependency
     * The request failed due to a failure of a previous request
     *
     * @var int
     */
    public const FAILED_DEPENDENCY = 424;

    /**
     * 请求超时
     * 服务器没有及时响应客户端请求
     *
     * Request Timeout
     * The server did not respond to the client request in a timely manner
     *
     * @var int
     */
    public const REQUEST_TIMEOUT = 408;

}
