<?php

namespace Illustrator\Foundation\Database\Eloquent;

use Illustrator\Waiter\Concerns\HasEvents;
use Illustrator\Waiter\Contracts\Summary;

class Model extends \Illuminate\Database\Eloquent\Model
{

    use HasEvents;

    /**
     * Summary class
     *
     * @var Summary
     */
    protected Summary $summary;

}
