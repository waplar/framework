<?php

namespace Artist\Waiter\Contracts\Hook;

use Artist\Waiter\Abstracts\Summary;

interface Migration
{

    /**
     * Triggered before migration is performed
     *
     * @param Summary $summary
     *
     * @return void
     */
    public function upBefore(Summary $summary): void;

    /**
     * Triggered after the migration is executed
     *
     * @param Summary $summary
     *
     * @return void
     */
    public function upAfter(Summary $summary): void;

    /**
     * Triggered before the rollback migration
     *
     * @param Summary $summary
     *
     * @return void
     */
    public function downBefore(Summary $summary): void;

    /**
     * Triggered after the rollback migration
     *
     * @param Summary $summary
     *
     * @return void
     */
    public function downAfter(Summary $summary): void;

}
