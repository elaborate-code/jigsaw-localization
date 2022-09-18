<?php

use ElaborateCode\JigsawLocalization\Composites\LangFolder;

it('lists available locals correctly', function () {
    $lang_loader = new LangFolder('/tests/lang');

    $this->assertContains('ar', $lang_loader->getLocalesList());
    $this->assertContains('en', $lang_loader->getLocalesList());
    $this->assertContains('fr', $lang_loader->getLocalesList());
});
