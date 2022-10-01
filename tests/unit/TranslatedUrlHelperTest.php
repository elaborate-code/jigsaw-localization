<?php

use ElaborateCode\JigsawLocalization\Mocks\PageMock;

test('path es => ar', function () {
    $page = (new PageMock)->setPath('/es/blog');

    expect(translate_path($page, 'ar'))->toBe('/ar/blog');
});

test('path ar <=> fr-CA', function () {
    expect(translate_path((new PageMock)->setPath('/ar/blog'), 'fr-CA'))->toBe('/fr-CA/blog');
    expect(translate_path((new PageMock)->setPath('/fr-CA/blog'), 'fr-CA'))->toBe('/fr-CA/blog');
});

test('path ar <=> haw-US', function () {
    expect(translate_path((new PageMock)->setPath('/ar/blog'), 'haw-US'))->toBe('/haw-US/blog');
    expect(translate_path((new PageMock)->setPath('/haw-US/blog'), 'haw-US'))->toBe('/haw-US/blog');
});

test('path haw-US <=> fr-CA', function () {
    expect(translate_path((new PageMock)->setPath('/fr-CA/blog'), 'haw-US'))->toBe('/haw-US/blog');
    expect(translate_path((new PageMock)->setPath('/haw-US/blog'), 'fr-CA'))->toBe('/fr-CA/blog');
});

test('path from DEFAULT_LOCALE', function () {
    expect(translate_path((new PageMock)->setPath('/blog'), 'ar'))->toBe('/ar/blog');
    expect(translate_path((new PageMock)->setPath('/blog'), 'en-UK'))->toBe('/en-UK/blog');
    expect(translate_path((new PageMock)->setPath('/blog'), 'haw-US'))->toBe('/haw-US/blog');
    expect(translate_path((new PageMock)->setPath('/blog'), packageDefaultLocale()))->toBe('/blog');
});

test('path to DEFAULT_LOCALE', function () {
    expect([
        translate_path((new PageMock)->setPath('/ar/blog')),
        translate_path((new PageMock)->setPath('/en-UK/blog')),
        translate_path((new PageMock)->setPath('/haw-US/blog')),
        translate_path((new PageMock)->setPath('/blog')),
    ])
        ->each
        ->toBe('/blog');
});
