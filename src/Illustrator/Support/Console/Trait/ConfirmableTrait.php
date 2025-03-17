<?php

namespace Illustrator\Support\Console\Trait;

use Closure;

use Illustrator\Support\Facades\Poet;

use function Laravel\Prompts\confirm;

trait ConfirmableTrait
{

    /**
     * 继续前确认
     * Confirm before proceeding
     *
     * @param string            $warning
     * @param bool|Closure|null $callback
     *
     * @return bool
     */
    public function confirmToProceed(
        string $warning = 'The application is currently in production!',
        bool|Closure $callback = null
    ): bool {
        $callback = is_null($callback) ? $this->getDefaultConfirmCallback() : $callback;

        $shouldConfirm = value($callback);

        if ($shouldConfirm) {
            if ($this->hasOption('force') && $this->option('force')) {
                return true;
            }

            Poet::warn($warning);

            $confirmed = confirm('Are you sure you want to run this command?', default: false);

            if (!$confirmed) {
                $this->components->warn('Cancel.');

                return false;
            }
        }

        return true;
    }

    /**
     * 获取默认确认回调
     * Gets the default confirmation callback
     *
     * @return Closure
     */
    protected function getDefaultConfirmCallback(): Closure
    {
        return function () {
            // 确定当前环境是否在生产中
            // Determine whether the current environment is in production
            return $this->getLaravel()->environment() === 'production';
        };
    }

}
