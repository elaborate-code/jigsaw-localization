<?php

use ElaborateCode\JigsawLocalization\Mocks\PageMock;

it('translates', function () {
    $page = (new PageMock)
        ->setLocalization([
            'es' => [
                'Cat' => 'Gato',
            ],
        ]);

    expect(__($page, 'Cat', 'es'))->toBe('Gato');
});

it('returns the given text when no translation is found', function () {
    $page = (new PageMock);

    expect(__($page, 'Dog', 'es'))->toBe('Dog');
});
