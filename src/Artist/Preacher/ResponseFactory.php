<?php

namespace Artist\Preacher;

use Closure;
use Illuminate\Database\Eloquent\Model;
use stdClass;

/**
 * Preacher class
 *
 * @author KanekiYuto
 */
class ResponseFactory
{

    /**
     * Message hook
     *
     * @var Closure
     */
    private Closure $hook;

    /**
     * Service status code
     *
     * @var int
     */
    private int $code = Response\Code::SUCCEED;

    /**
     * Service status code
     *
     * @var int
     */
    private int $status = Response\Status::SUCCEED;

    /**
     * Decision status code of business logic (it will not be exported)
     *
     * @var int
     */
    private int $decide = Response\Decide::SUCCEED;

    /**
     * Response message
     *
     * @var string
     */
    private string $msg = '';

    /**
     * Response data
     *
     * @var array
     */
    private array $data = [];

    /**
     * Eloquent model
     *
     * @var mixed
     */
    private mixed $model;

    /**
     * Construct a Preacher instance
     */
    public function __construct(Closure $hook = null)
    {
        if (is_null($hook)) {
            $hook = function (self $instance) {
                // ...
            };
        }

        $this->hook = $hook;
    }

    /**
     * Mount the hook processing closure
     *
     * @param Closure $closure
     *
     * @return static
     */
    public function useHook(Closure $closure): static
    {
        $this->hook = $closure;

        return $this;
    }

    /**
     * Set both the response message and response service status code
     *
     * @param int    $code
     * @param string $msg
     *
     * @return static
     */
    public function msgCode(int $code, string $msg): static
    {
        return $this->setCode($code)->setMsg($msg);
    }

    /**
     * Verify and return to the default
     *
     * @param bool   $allow
     * @param static $pass
     * @param static $noPass
     *
     * @return static
     */
    public function allow(bool $allow, self $pass, self $noPass): static
    {
        return $allow ? $pass : $noPass;
    }

    /**
     * Equivalent to setReceipt()
     *
     * @param object $data
     *
     * @return static
     */
    public function receipt(object $data): static
    {
        return $this->setReceipt($data);
    }

    /**
     * Set the receipt information
     *
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
     * Set up Eloquent model
     *
     * @param Model $model
     *
     * @return static
     */
    public function model(Model $model): static
    {
        return $this->setModel($model);
    }

    /**
     * Equivalent to setRows()
     *
     * @param array $data
     *
     * @return static
     */
    public function rows(array $data): static
    {
        return $this->setRows($data);
    }

    /**
     * Set row data
     *
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
     * Returns the underlying response information
     *
     * @return static
     */
    public function base(): static
    {
        return $this;
    }

    /**
     * Equivalent to setMessage()
     *
     * @param string $msg
     *
     * @return static
     */
    public function msg(string $msg): static
    {
        return $this->setMsg($msg);
    }

    /**
     * Equivalent to setCode()
     *
     * @param int $code
     *
     * @return static
     */
    public function code(int $code): static
    {
        return $this->setCode($code);
    }

    /**
     * Equivalent to setStatus()
     *
     * @param int $status
     *
     * @return static
     */
    public function status(int $status): static
    {
        return $this->setStatus($status);
    }

    /**
     * Equivalent to setDecide()
     *
     * @param int $decide
     *
     * @return static
     */
    public function decide(int $decide): static
    {
        return $this->setDecide($decide);
    }

    /**
     * Equivalent to setPaging()
     *
     * @param int   $page
     * @param int   $prePage
     * @param int   $total
     * @param array $data
     *
     * @return static
     */
    public function paging(int $page, int $prePage, int $total, array $data): static
    {
        return $this->setPaging($page, $prePage, $total, $data);
    }

    /**
     * Set page information
     *
     * @param int   $page
     * @param int   $prePage
     * @param int   $total
     * @param array $rows
     *
     * @return static
     */
    public function setPaging(
        int $page,
        int $prePage,
        int $total,
        array $rows
    ): static {
        $this->data['paging'] = (object) [
            'page' => $page,
            'prePage' => $prePage,
            'total' => $total,
            'rows' => $rows,
        ];

        return $this;
    }

    /**
     * Get paging information
     *
     * @return object
     */
    public function getPaging(): object
    {
        return $this->data['paging'];
    }

    /**
     * Merge receipt information
     *
     * @param stdClass $value
     *
     * @return static
     */
    public function mergeReceipt(stdClass $value): static
    {
        $this->data['receipt'] = array_merge(
            (array) $this->data['receipt'],
            (array) $value
        );

        return $this;
    }

    /**
     * Return receipt information
     *
     * @return object
     */
    public function getReceipt(): object
    {
        return $this->data['receipt'];
    }

    /**
     * Merge line information
     *
     * @param array $value
     *
     * @return static
     */
    public function mergeRows(array $value): static
    {
        $this->data['rows'] = array_merge(
            $this->data['rows'],
            $value
        );

        return $this;
    }

    /**
     * Get row data
     *
     * @return array
     */
    public function getRows(): array
    {
        return $this->data['rows'];
    }

    /**
     * Decide success
     *
     * @return bool
     */
    public function isDecideSucceed(): bool
    {
        return $this->code === Response\Decide::SUCCEED;
    }

    /**
     * Export response
     *
     * @return Export
     */
    public function export(): Export
    {
        $hookClosure = $this->hook;

        $hookClosure($this);

        return new Export(array_merge([
            Response\DefaultSetting::KEY_STATUS => $this->getStatus(),
            Response\DefaultSetting::KEY_CODE => $this->getCode(),
            Response\DefaultSetting::KEY_MESSAGE => $this->getMsg(),
        ], $this->data));
    }

    /**
     * Get the service status code
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Set the service status code
     *
     * @param int $status
     *
     * @return static
     */
    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Gets the response status code
     *
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Set the response status code
     *
     * @param int $code
     *
     * @return static
     */
    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Set the response status code to obtain the response message
     *
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * Set response message
     *
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
     * Get Eloquent model
     *
     * @return mixed
     */
    public function getModel(): mixed
    {
        return $this->model;
    }

    /**
     * Set up Eloquent model
     *
     * @param Model $model
     *
     * @return static
     */
    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the decision status code
     *
     * @return int
     */
    public function getDecide(): int
    {
        return $this->decide;
    }

    /**
     * Set the decision status code
     *
     * @param int $decide
     *
     * @return static
     */
    public function setDecide(int $decide): static
    {
        $this->decide = $decide;

        return $this;
    }

}
