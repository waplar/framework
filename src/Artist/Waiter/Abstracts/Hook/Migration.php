<?php

namespace Artist\Waiter\Abstracts\Hook;

use Artist\Waiter\Abstracts\Summary;

abstract class Migration implements \Artist\Waiter\Contracts\Hook\Migration
{

    abstract public function upBefore(Summary $summary): void;

    abstract public function upAfter(Summary $summary): void;

    abstract public function downBefore(Summary $summary): void;

    abstract public function downAfter(Summary $summary): void;

}
