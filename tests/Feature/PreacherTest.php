<?php

use Artist\Preacher\Response\Code;
use Artist\Preacher\Response\DefaultSetting;
use Artist\Preacher\ResponseFactory;
use Artist\Support\Facades\Preacher;
use Illuminate\Support\Facades\Facade;

beforeEach(function () {
    Facade::setFacadeApplication(app());

    app()->bind(Preacher::FACADE_ACCESSOR, function () {
        return new ResponseFactory(function (ResponseFactory $instance) {
            $instance->setMsg('global-hooked-' . $instance->getMsg());
        });
    });
});

it('Tests the facade instance for contamination', function () {
    Preacher::msg('test');

    expect(Preacher::base()->getMsg())->not()->toBe('test');
});

it('Simulated facade', function () {
    expect(app()->bound(Preacher::FACADE_ACCESSOR))->toBeTrue();
});

it('Basic testing', function () {
    $cases = collect()
        ->push(Preacher::base()->export()->array())
        ->push(Preacher::msg('test')->export()->array()[DefaultSetting::KEY_MESSAGE])
        ->push(Preacher::code(Code::SUCCEED)->export()->array()[DefaultSetting::KEY_CODE]);

    expect($cases[0])
        ->toHaveKeys([DefaultSetting::KEY_CODE, DefaultSetting::KEY_STATUS, DefaultSetting::KEY_MESSAGE])
        ->and($cases[1])
        ->toBe('global-hooked-test')
        ->and($cases[2])
        ->toBe(Code::SUCCEED);
});

it('Test whether the Hook works', function () {
    $cases = collect()
        ->push(Preacher::msg('test')->export()->array()[DefaultSetting::KEY_MESSAGE])
        ->push(Preacher::msg('test')->useHook(function (ResponseFactory $instance) {
            $instance->setMsg('hooked-' . $instance->getMsg());
        })->export()->array()[DefaultSetting::KEY_MESSAGE])->all();

    expect($cases[0])
        ->toBe('global-hooked-test')
        ->and($cases[1])
        ->toBe('hooked-test');
});
