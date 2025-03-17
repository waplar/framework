<?php

use Illustrator\Foundation\Database\Eloquent\Casts\AutoTimezone;
use Illustrator\Waiter\Blueprint;
use Illustrator\Waiter\Schema;
use Illustrator\Waiter\Waiter;

return Waiter::configure()->withTable(
    'test_case_one',
    'Test case one'
)->withSchema(function (Schema $schema) {

    $schema->create(function (Blueprint $table) {
        $table->comment('Test');

        $table->group([
            $table->bigInteger('id')->primary()->unique()->comment('ID'),
            $table->string('name', 32)->comment('Name'),
            $table->string('explain', 64)->nullable()->comment('Explain'),
            $table->string('route')->comment('Route name'),
        ], function (Schema\ColumnDefinition $definition) {
            return $definition->summary()->fillable();
        });

        $table->group([
            $table->bigInteger('created_at')->comment('Created'),
            $table->bigInteger('updated_at')->comment('Updated'),
        ], function (Schema\ColumnDefinition $definition) {
            return $definition->summary()->cast(AutoTimezone::class)->fillable();
        });
    });

}, function (Schema $schema) {

    $schema->dropIfExists();

});
