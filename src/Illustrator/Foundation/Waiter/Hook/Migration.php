<?php

namespace Illustrator\Foundation\Waiter\Hook;

use Illustrator\Waiter\Abstracts\Hook\Migration as Hook;
use Illustrator\Waiter\Abstracts\Summary;

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
