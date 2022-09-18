<?php

use ElaborateCode\JigsawLocalization\Helpers\File;
use ElaborateCode\JigsawLocalization\Helpers\LocaleFolderFactory;

it('sets locale lang correctly', function () {
    $factory = new LocaleFolderFactory;

    $en = new File('/tests/feat/lang/en');

    $locale = $factory->make($en);

    $this->assertEquals($locale->getLang(), 'en');

    $this->assertFalse($locale->isMulti());
});

it('assertJsonsList', function () {
    $factory = new LocaleFolderFactory;

    $en = new File('/tests/feat/lang/en');

    $locale = $factory->make($en);

    $this->assertArrayHasKey('en.json', $locale->getJsonsList());
});
