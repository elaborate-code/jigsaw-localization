<?php

use ElaborateCode\JigsawLocalization\Composites\LangFolder;

it('lists available locals correctly', function () {
    $lang_loader = new LangFolder('/tests/feat/lang');

    $this->assertContains('ar', $lang_loader->getLocalesList());
    $this->assertContains('en', $lang_loader->getLocalesList());
    $this->assertContains('fr', $lang_loader->getLocalesList());
});

it('dumps', function () {
    $lang_loader = new LangFolder('/tests/feat/lang');

    // var_dump($lang_loader->getLocales());
});
