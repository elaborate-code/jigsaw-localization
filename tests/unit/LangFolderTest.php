<?php

use ElaborateCode\JigsawLocalization\Composites\LangFolder;
it('lists available locales correctly', function () {
    $lang_folder = new LangFolder('/tests/lang');

    $this->assertContains('ar', $lang_folder->getLocalesList());
    $this->assertContains('en', $lang_folder->getLocalesList());
    $this->assertContains('es', $lang_folder->getLocalesList());
    $this->assertContains('fr', $lang_folder->getLocalesList());
});

it('lists available locals correctly', function () {
    $lang_loader = new LangFolder('/tests/lang');

    $this->assertContains('ar', $lang_loader->getLocalesList());
    $this->assertContains('en', $lang_loader->getLocalesList());
    $this->assertContains('fr', $lang_loader->getLocalesList());
});
