<?php

use ElaborateCode\JigsawLocalization\Mocks\PageMock;

it('sets path on DEFAULT_LOCALE for partial path', function () {
    $page = new PageMock;

    expect(locale_path($page, 'blog'))->toBe('/blog');
});

it('sets path on locale for partial path', function () {
    $page = new PageMock;

    expect(locale_path($page, 'blog', 'ar'))->toBe('/ar/blog');
});
