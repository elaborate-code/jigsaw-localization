<?php

use ElaborateCode\JigsawLocalization\Mocks\PageMock;

it('sets URL with base path on DEFAULT_LOCALE for partial path', function () {
    $this->app->config = collect(['baseUrl' => 'https://elaboratecode.com/packages']);

    $page = new PageMock;

    expect(locale_url($page, 'blog'))->toBe('https://elaboratecode.com/packages/blog');
});

it('sets URL with base path on locale for partial path', function () {
    $this->app->config = collect(['baseUrl' => 'https://elaboratecode.com/packages']);

    $page = new PageMock;

    expect(locale_url($page, 'blog', 'ar'))->toBe('https://elaboratecode.com/packages/ar/blog');
});
