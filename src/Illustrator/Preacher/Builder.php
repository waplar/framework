<?php

namespace Illustrator\Preacher;

use Closure;
use stdClass;
use Illustrator\Preacher\Constants\DefaultSetting;

class Builder
{

    /**
     * @var Closure
     */
    private Closure $hook;

    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var string
     */
    private string $msg;

    /**
     * @var array
     */
    private array $data = [];

    /**
     * @var int
     */
    private int $httpStatus = Constants\DefaultSetting::HTTP_STATUS;

    /**
     * @var array
     */
    private array $headers = [];

    /**
     * @var array
     */
    private array $jsonResponse;

    /**
     * @param  Closure  $hook
     * @param  string   $msg
     * @param  int      $statusCode
     */
    public function __construct(
        Closure $hook,
        string $msg = Constants\DefaultSetting::MSG,
        int $statusCode = Constants\DefaultSetting::STATUS_CODE
    ) {
        $this->setHook($hook);
        $this->setMsg($msg);
        $this->setStatusCode($statusCode);
        $this->setJsonResponse();
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return array_merge([
            DefaultSetting::KEY_STATUS_CODE => $this->getStatusCode(),
            DefaultSetting::KEY_MESSAGE => $this->getMsg(),
        ], $this->getData());
    }

    /**
     * @param  int   $options
     * @param  bool  $json
     *
     * @return static
     */
    public function setJsonResponse(int $options = Constants\DefaultSetting::JSON_OPTIONS, bool $json = false): static
    {
        $this->jsonResponse = compact(['options', 'json']);

        return $this;
    }

    /**
     * @return array
     */
    public function getJsonResponse(): array
    {
        return $this->jsonResponse;
    }

    /**
     * @param  int  $value
     *
     * @return static
     */
    public function setHttpStatus(int $value): static
    {
        $this->httpStatus = $value;

        return $this;
    }

    /**
     * @param  array  $value
     *
     * @return static
     */
    public function setHeaders(array $value): static
    {
        $this->headers = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return int
     */
    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * @param  stdClass  $value
     *
     * @return static
     */
    public function setReceipt(stdClass $value): static
    {
        $this->data[DefaultSetting::KEY_RECEIPT] = $value;

        return $this;
    }

    /**
     * @param  array  $value
     *
     * @return static
     */
    public function setRows(array $value): static
    {
        $this->data[DefaultSetting::KEY_ROWS] = $value;

        return $this;
    }

    /**
     * @param  int    $page
     * @param  int    $pages
     * @param  int    $total
     * @param  array  $rows
     *
     * @return static
     */
    public function setPaging(int $page, int $pages, int $total, array $rows): static
    {
        $this->data[DefaultSetting::KEY_PAGING] = (object) [
            'page' => $page,
            'pages' => $pages,
            'total' => $total,
            'rows' => $rows,
        ];

        return $this;
    }

    /**
     * @return Export
     */
    public function export(): Export
    {
        return new Export(array_merge([
            Constants\DefaultSetting::KEY_STATUS_CODE => $this->getStatusCode(),
            Constants\DefaultSetting::KEY_MESSAGE => $this->getMsg(),
        ], $this->getData()));
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param  int  $statusCode
     *
     * @return static
     */
    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->getHook()(
            $this->msg,
            $this->data
        )[DefaultSetting::KEY_MESSAGE] ?? $this->msg;
    }

    /**
     * @param  string  $message
     *
     * @return static
     */
    public function setMsg(string $message): static
    {
        $this->msg = $message;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->getHook()(
            $this->msg,
            $this->data
        )[DefaultSetting::KEY_DATA] ?? $this->data;
    }

    /**
     * @return array
     */
    public function getRows(): array
    {
        return $this->getData()['rows'] ?? [];
    }

    /**
     * @return stdClass
     */
    public function getReceipt(): stdClass
    {
        return $this->getData()['receipt'] ?? (object) [];
    }

    /**
     * @return stdClass
     */
    public function getPaging(): stdClass
    {
        return $this->getData()['paging'] ?? (object) [
            'page' => 0,
            'prePage' => 0,
            'total' => 0,
            'rows' => [],
        ];
    }

    /**
     * @param  Closure  $value
     *
     * @return void
     */
    private function setHook(Closure $value): void
    {
        $this->hook = $value;
    }

    /**
     * @return Closure
     */
    private function getHook(): Closure
    {
        return $this->hook;
    }

}
