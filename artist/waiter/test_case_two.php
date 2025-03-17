<?php

use Illustrator\Foundation\Database\Eloquent\Casts\AutoTimezone;
use Illustrator\Waiter\Blueprint;
use Illustrator\Waiter\Schema;
use Illustrator\Waiter\Waiter;

return Waiter::configure()->withTable(
    'case_two',
    'Test case two'
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

})->withSummary('', 'CaseTwo');
