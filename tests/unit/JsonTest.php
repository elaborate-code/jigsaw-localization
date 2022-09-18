<?php

use ElaborateCode\JigsawLocalization\Composites\LocaleJson;
use ElaborateCode\JigsawLocalization\Helpers\File;

it('gets JSON content correctly', function () {
    $file = new File('/tests/lang/en/en.json');

    $json = new LocaleJson($file);

    $this->assertArrayHasKey('en', $json->getContent());
    $this->assertContains('en', $json->getContent());
});
