<?php

use Illustrator\Foundation\Database\Eloquent\Casts\AutoTimezone;
use Illustrator\Waiter\Blueprint;
use Illustrator\Waiter\Schema\ColumnDefinition;
use Illustrator\Waiter\Waiter;

return Waiter::configure()->withTable(
    'case_two',
    'Test case two'
)->withBlueprint(function (Blueprint $blueprint) {
    $blueprint->bigInteger('id')->primary()->unique()->comment('ID');

    $blueprint->group([
        $blueprint->bigInteger('created_at')->comment('Created'),
        $blueprint->bigInteger('updated_at')->comment('Updated'),
    ], function (ColumnDefinition $definition) {
        return $definition->cast(AutoTimezone::class)->fillable();
    });
})->withSummary('', 'CaseTwo');
