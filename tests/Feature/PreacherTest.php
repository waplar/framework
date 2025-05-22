<?php

use Illustrator\Preacher\Constants\DefaultSetting;
use Illustrator\Preacher\Preacher;

beforeEach(function () {
    Illustrator\Preacher\Preacher::useHook(function (string $msg, array $data) {
        if ($msg === 'The value in the value is multiplied by two') {
            $data['rows'] = collect($data['rows'])->map(function (int $value) {
                return $value * 2;
            })->toArray();
        }

        return [
            DefaultSetting::KEY_MESSAGE => "pest-$msg",
            DefaultSetting::KEY_DATA => $data,
        ];
    });
});

it('Tests whether the hook is valid', function () {
    expect(
        Preacher::basic('test')->getMsg()
    )->toBe('pest-test')->and(
        Preacher::rows([1, 2, 3,])->setMsg(
            'The value in the value is multiplied by two'
        )->getRows()
    )->toBe([2, 4, 6]);
});
