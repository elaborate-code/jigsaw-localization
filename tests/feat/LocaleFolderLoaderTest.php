<?php

use ElaborateCode\JigsawLocalization\Helpers\File;
use ElaborateCode\JigsawLocalization\Helpers\LocaleFolderLoaderFactory;

it('sets locale lang correctly', function () {
    $factory = new LocaleFolderLoaderFactory;

    $en = new File('/tests/feat/lang/en');

    $locale = $factory->make($en, 'en');

    $this->assertEquals($locale->getLang(), 'en');

    $this->assertFalse($locale->isMulti());
});

it('assertJsonsList', function () {
    $factory = new LocaleFolderLoaderFactory;

    $en = new File('/tests/feat/lang/en');

    $locale = $factory->make($en, 'en');

    $this->assertArrayHasKey('en.json', $locale->getJsonsList());
});
