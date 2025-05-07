<?php

use Illustrator\Waiter\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illustrator\Waiter\Schema\ColumnDefinition;
use Illustrator\Foundation\Database\Eloquent\Casts\AutoTimezone;
use Illustrator\Waiter\Waiter;
use Illustrator\Waiter\Schema\ModelDefinition;

return Waiter::configure()->withTable(
    'case_four',
    'Test case four'
)->withBlueprint(function (Blueprint $blueprint) {
    $blueprint->comment('test');
    $blueprint->unique([
        'id',
        'uuid',
    ]);

    $blueprint->bigInteger('id', true)->summary()->primary()->unique()->comment('ID');

    $blueprint->ulid();
    $blueprint->uuid();

    $blueprint->group([
        $blueprint->bigInteger('created_at')->comment('Created'),
        $blueprint->bigInteger('updated_at')->comment('Updated'),
    ], function (ColumnDefinition $definition) {
        return $definition->summary()->cast(AutoTimezone::class)->fillable();
    });
})->withModel(
    Model::class
)->withModelDefinition(
    (new ModelDefinition())->timestamps()->incrementing()
)->withMigration();
