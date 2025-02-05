<?php

namespace Artist\Support\Console\Trait;

use Closure;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\warning;

/**
 * 命令行确认
 *
 * @author KanekiYuto
 */
trait ConfirmableTrait
{

    /**
     * 继续前确认
     *
     * @param string            $warning
     * @param bool|Closure|null $callback
     *
     * @return bool
     */
    public function confirmToProceed(
        string $warning = '该应用程序目前处于生产状态！',
        bool|Closure $callback = null
    ): bool {
        $callback = is_null($callback) ? $this->getDefaultConfirmCallback() : $callback;

        $shouldConfirm = value($callback);

        if ($shouldConfirm) {
            if ($this->hasOption('force') && $this->option('force')) {
                return true;
            }

            warning($warning);

            $confirmed = confirm('您确定要运行这个命令吗？', default: false);

            if (!$confirmed) {
                $this->components->warn('取消。');

                return false;
            }
        }

        return true;
    }

    /**
     * 获取默认确认回调
     *
     * @return Closure
     */
    protected function getDefaultConfirmCallback(): Closure
    {
        return function () {
            // 确定当前环境是否在生产中
            return $this->getLaravel()->environment() === 'production';
        };
    }

}
