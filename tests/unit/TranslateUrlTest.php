<?php

use ElaborateCode\JigsawLocalization\Mocks\PageMock;

test('URL with base path es => ar', function () {
    $this->app->config = collect(['baseUrl' => 'https://elaboratecode.com/packages']);

    $page = (new PageMock)->setPath('/es/blog');

    expect(translate_url($page, 'ar'))->toBe('https://elaboratecode.com/packages/ar/blog');
});

test('URL with base path ar <=> fr-CA', function () {
    $this->app->config = collect(['baseUrl' => 'https://elaboratecode.com/packages']);

    expect(translate_url((new PageMock)->setPath('/ar/blog'), 'fr-CA'))->toBe('https://elaboratecode.com/packages/fr-CA/blog');
    expect(translate_url((new PageMock)->setPath('/fr-CA/blog'), 'fr-CA'))->toBe('https://elaboratecode.com/packages/fr-CA/blog');
});

test('URL with base path ar <=> haw-US', function () {
    $this->app->config = collect(['baseUrl' => 'https://elaboratecode.com/packages']);

    expect(translate_url((new PageMock)->setPath('/ar/blog'), 'haw-US'))->toBe('https://elaboratecode.com/packages/haw-US/blog');
    expect(translate_url((new PageMock)->setPath('/haw-US/blog'), 'haw-US'))->toBe('https://elaboratecode.com/packages/haw-US/blog');
});

test('URL with base path haw-US <=> fr-CA', function () {
    $this->app->config = collect(['baseUrl' => 'https://elaboratecode.com/packages']);

    expect(translate_url((new PageMock)->setPath('/fr-CA/blog'), 'haw-US'))->toBe('https://elaboratecode.com/packages/haw-US/blog');
    expect(translate_url((new PageMock)->setPath('/haw-US/blog'), 'fr-CA'))->toBe('https://elaboratecode.com/packages/fr-CA/blog');
});

test('URL with base path from DEFAULT_LOCALE', function () {
    $this->app->config = collect(['baseUrl' => 'https://elaboratecode.com/packages']);

    expect(translate_url((new PageMock)->setPath('/blog'), 'ar'))->toBe('https://elaboratecode.com/packages/ar/blog');
    expect(translate_url((new PageMock)->setPath('/blog'), 'en-UK'))->toBe('https://elaboratecode.com/packages/en-UK/blog');
    expect(translate_url((new PageMock)->setPath('/blog'), 'haw-US'))->toBe('https://elaboratecode.com/packages/haw-US/blog');
    expect(translate_url((new PageMock)->setPath('/blog'), packageDefaultLocale()))->toBe('https://elaboratecode.com/packages/blog');
});

test('URL with base path to DEFAULT_LOCALE', function () {
    $this->app->config = collect(['baseUrl' => 'https://elaboratecode.com/packages']);

    expect([
        translate_url((new PageMock)->setPath('/ar/blog')),
        translate_url((new PageMock)->setPath('/en-UK/blog')),
        translate_url((new PageMock)->setPath('/haw-US/blog')),
        translate_url((new PageMock)->setPath('/blog')),
    ])
        ->each
        ->toBe('https://elaboratecode.com/packages/blog');
});
