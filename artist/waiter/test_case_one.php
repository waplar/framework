<?php

use Illustrator\Foundation\Database\Eloquent\Casts\AutoTimezone;
use Illustrator\Waiter\Blueprint;
use Illustrator\Waiter\Schema\ColumnDefinition;
use Illustrator\Waiter\Waiter;

return Waiter::configure()->withTable(
    'test_case_one',
    'Test case one'
)->withBlueprint(function (Blueprint $blueprint) {
    $blueprint->comment('Test');

    $blueprint->group([
        $blueprint->bigInteger('id')->primary()->unique()->comment('ID'),
        $blueprint->string('name', 32)->comment('Name'),
        $blueprint->string('explain', 64)->nullable()->comment('Explain'),
        $blueprint->string('route')->comment('Route name'),
    ], function (ColumnDefinition $definition) {
        return $definition->summary()->fillable();
    });

    $blueprint->group([
        $blueprint->bigInteger('created_at')->comment('Created'),
        $blueprint->bigInteger('updated_at')->comment('Updated'),
    ], function (ColumnDefinition $definition) {
        return $definition->summary()->cast(AutoTimezone::class)->fillable();
    });
});
