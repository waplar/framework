<?php

$command = 'waplar:waiter';

it("Test command [$command] exception use case one", function () use ($command) {
    $this->artisan(
        $command,
        ['pattern' => 'test']
    )->assertFailed();
});

it("Test command [$command] exception use case two", function () use ($command) {
    $this->artisan(
        $command,
        ['pattern' => 'multiselect']
    )->expectsQuestion(
        'Select the files you want to execute!',
        ['test_case_one']
    )->assertFailed();
});

it("Test command [$command] exception use case three", function () use ($command) {
    $files = collect(['test_case_one'])->map(function (string $filename) {
        return waiter_path("$filename.php");
    });

    $this->artisan(
        $command,
        ['pattern' => 'multiselect']
    )->expectsQuestion(
        'Select the files you want to execute!',
        $files->all()
    )->assertSuccessful();
});

it("Test command [$command] exception use case four", function () use ($command) {
    $files = collect(['test_case_three'])->map(function (string $filename) {
        return waiter_path("$filename.php");
    });

    $this->artisan(
        $command,
        ['pattern' => 'multiselect']
    )->expectsQuestion(
        'Select the files you want to execute!',
        $files->all()
    )->assertFailed();
});

it("Test command [$command] exception use case five", function () use ($command) {
    $files = collect(['test_case_one', 'test_case_two', 'test_case_four'])->map(function (string $filename) {
        return waiter_path("$filename.php");
    });

    $this->artisan(
        $command,
        ['pattern' => 'multiselect']
    )->expectsQuestion(
        'Select the files you want to execute!',
        $files->all()
    )->assertSuccessful();
});

it("Test command [$command] exception use case six", function () use ($command) {
    $files = collect(['test_case_four'])->map(function (string $filename) {
        return waiter_path("$filename.php");
    });

    $this->artisan(
        $command,
        ['pattern' => 'multiselect']
    )->expectsQuestion(
        'Select the files you want to execute!',
        $files->all()
    )->assertSuccessful();
});
