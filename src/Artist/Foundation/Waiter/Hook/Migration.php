<?php

namespace Artist\Foundation\Waiter\Hook;

use Artist\Waiter\Abstracts\Hook\Migration as Hook;
use Artist\Waiter\Abstracts\Summary;

/**
 * Basic migration hook
 *
 * @author KanekiYuto
 */
class Migration extends Hook
{

    public function upBefore(Summary $summary): void
    {
        // Do it...
    }

    public function upAfter(Summary $summary): void
    {
        // Do it...
    }

    public function downBefore(Summary $summary): void
    {
        // Do it...
    }

    public function downAfter(Summary $summary): void
    {
        // Do it...
    }

}
