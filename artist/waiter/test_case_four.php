<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illustrator\Foundation\Database\Eloquent\Casts\AutoTimezone;
use Illustrator\Waiter\Blueprint;
use Illustrator\Waiter\Schema\ColumnDefinition;
use Illustrator\Waiter\Schema\ModelDefinition;
use Illustrator\Waiter\Waiter;

return Waiter::configure()->withTable(
    'case_four',
    'Test case four'
)->withBlueprint(function (Blueprint $blueprint) {
    $blueprint->comment('test');
    $blueprint->unique([
        'id',
        'uuid',
    ]);

    $blueprint->bigInteger('id', true)->primary()->unique()->comment('ID');

    $blueprint->ulid();
    $blueprint->uuid();

    $blueprint->group([
        $blueprint->bigInteger('created_at')->comment('Created'),
        $blueprint->bigInteger('updated_at')->comment('Updated'),
    ], function (ColumnDefinition $definition) {
        return $definition->cast(AutoTimezone::class)->fillable();
    });
})->withModel(
    Model::class,
    use: [HasUuids::class]
)->withModelDefinition(
    (new ModelDefinition())->timestamps()->incrementing()
)->withMigration();
