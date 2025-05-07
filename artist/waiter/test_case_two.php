<?php

use Illustrator\Waiter\Blueprint;
use Illustrator\Waiter\Schema\ColumnDefinition;
use Illustrator\Foundation\Database\Eloquent\Casts\AutoTimezone;
use Illustrator\Waiter\Waiter;

return Waiter::configure()->withTable(
    'case_two',
    'Test case two'
)->withBlueprint(function (Blueprint $blueprint) {
    $blueprint->bigInteger('id')->summary()->primary()->unique()->comment('ID');

    $blueprint->group([
        $blueprint->bigInteger('created_at')->comment('Created'),
        $blueprint->bigInteger('updated_at')->comment('Updated'),
    ], function (ColumnDefinition $definition) {
        return $definition->summary()->cast(AutoTimezone::class)->fillable();
    });
})->withSummary('', 'CaseTwo');
