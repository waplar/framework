<?php

namespace Artist\Preacher;

use Closure;
use stdClass;

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
     * @param Closure $hook
     * @param string  $msg
     * @param int     $statusCode
     */
    public function __construct(
        Closure $hook,
        string $msg = '',
        int $statusCode = Constants\CodeStatus::SUCCEED
    ) {
        $this->setHook($hook);
        $this->setMsg($msg);
        $this->setStatusCode($statusCode);
    }

    /**
     * @param stdClass $value
     *
     * @return static
     */
    public function setReceipt(stdClass $value): static
    {
        $this->data['receipt'] = $value;

        return $this;
    }

    /**
     * @param array $value
     *
     * @return static
     */
    public function setRows(array $value): static
    {
        $this->data['rows'] = $value;

        return $this;
    }

    /**
     * @param int   $page
     * @param int   $prePage
     * @param int   $total
     * @param array $rows
     *
     * @return static
     */
    public function setPaging(int $page, int $prePage, int $total, array $rows): static
    {
        $this->data['paging'] = (object) [
            'page' => $page,
            'prePage' => $prePage,
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
     * @param int $statusCode
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
        )[0] ?? $this->msg;
    }

    /**
     * @param string $message
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
        )[1] ?? $this->data;
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
     * @param Closure $value
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
