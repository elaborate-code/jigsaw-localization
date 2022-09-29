<?php

use ElaborateCode\JigsawLocalization\Mocks\PageMock;

it('returns DEFAULT_LOCALE code', function () {
    expect([
        current_path_lang((new PageMock)->setPath('/')),
        current_path_lang((new PageMock)->setPath('/blog')),
    ])
        ->each
        ->toBe(packageDefaultLang());
});

it('returns language code', function () {
    expect([
        current_path_lang((new PageMock)->setPath('/es')),
        current_path_lang((new PageMock)->setPath('/es/blog')),
    ])
        ->each
        ->toBe('es');
});

it('returns language+region code', function () {
    expect([
        current_path_lang((new PageMock)->setPath('/haw-US')),
        current_path_lang((new PageMock)->setPath('/haw-US/blog')),
    ])
        ->each
        ->toBe('haw-US');
});
