<?php

use ElaborateCode\JigsawLocalization\Mocks\PageMock;

it('sets path on DEFAULT_LOCALE for partial path', function () {
    $this->app->config = collect(['baseUrl' => '']);

    $page = new PageMock;

    expect(locale_url($page, 'blog'))->toBe('/blog');
});

it('sets path on locale for partial path', function () {
    $this->app->config = collect(['baseUrl' => '']);

    $page = new PageMock;

    expect(locale_url($page, 'blog', 'ar'))->toBe('/ar/blog');
});
