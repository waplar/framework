<?php

namespace Illustrator\Waiter\Abstracts\Hook;

use Illustrator\Waiter\Abstracts\Summary;

abstract class Migration implements \Illustrator\Waiter\Contracts\Hook\Migration
{

    abstract public function upBefore(Summary $summary): void;

    abstract public function upAfter(Summary $summary): void;

    abstract public function downBefore(Summary $summary): void;

    abstract public function downAfter(Summary $summary): void;

}
