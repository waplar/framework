<?php

use Artist\Waiter\Schema;
use Artist\Waiter\Waiter;
use Artist\Waiter\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Artist\Foundation\Database\Eloquent\Casts\AutoTimezone;

return Waiter::configure()->withTable(
    'case_four',
    'Test case four'
)->withSchema(function (Schema $schema) {

    $schema->create(function (Blueprint $table) {
        $table->bigInteger('id')->summary()->primary()->unique()->comment('ID');

        $table->group([
            $table->bigInteger('created_at')->comment('Created'),
            $table->bigInteger('updated_at')->comment('Updated'),
        ], function (Schema\ColumnDefinition $definition) {
            return $definition->summary()->cast(AutoTimezone::class)->fillable();
        });
    });

}, function (Schema $schema) {

    $schema->dropIfExists();

})->withModel(
    Model::class
)->withModelDefinition(
    (new Artist\Waiter\Schema\ModelDefinition())
        ->timestamps()
        ->incrementing()
);
