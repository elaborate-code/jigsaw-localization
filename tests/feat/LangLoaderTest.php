<?php

use ElaborateCode\JigsawLocalization\Helpers\File;
use ElaborateCode\JigsawLocalization\Loaders\LangLoader;

it('gets correct project root path', function () {
    $lang_loader = new LangLoader('/tests/feat/lang');

    $lang_folder = new File('/tests/feat/lang');

    $this->assertArrayHasKey('ar', $lang_loader->getLocalesList());
    $this->assertArrayHasKey('en', $lang_loader->getLocalesList());
    $this->assertArrayHasKey('fr', $lang_loader->getLocalesList());

    $this->assertContains(realpath($lang_folder . DIRECTORY_SEPARATOR . 'ar'), $lang_loader->getLocalesList());
    $this->assertContains(realpath($lang_folder . DIRECTORY_SEPARATOR . 'en'), $lang_loader->getLocalesList());
    $this->assertContains(realpath($lang_folder . DIRECTORY_SEPARATOR . 'fr'), $lang_loader->getLocalesList());
});

it('dumps', function () {
    $lang_loader = new LangLoader('/tests/feat/lang');

    // var_dump($lang_loader->getLocalesLoadersList());
});
