<?php

use ElaborateCode\JigsawLocalization\Mocks\PageMock;

test('yo', function () {
    $page = (new PageMock)->setPath('es/blog');

    expect(translated_url($page, 'es', 'en'))->toBe('en/blog');
});
