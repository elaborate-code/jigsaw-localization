<?php

use ElaborateCode\JigsawLocalization\Composites\LocaleJson;
use ElaborateCode\JigsawLocalization\Strategies\File;

it('gets JSON content correctly', function () {
    $file = new File('/tests/lang/en/en.json');

    $json = new LocaleJson($file);

    $this->assertArrayHasKey('en', $json->getContent());
    $this->assertContains('en', $json->getContent());
});

it('gets multi JSON content correctly', function () {
    $file = new File('/tests/lang/multi/greetings.json');

    $json = new LocaleJson($file);

    $this->assertCount(2, $json->getContent());
    $this->assertArrayHasKey('en', $json->getContent());
    $this->assertArrayHasKey('fr', $json->getContent());

    $this->assertArrayHasKey('Hello', $json->getContent()['en']);
    $this->assertArrayHasKey('Hello', $json->getContent()['fr']);
});
