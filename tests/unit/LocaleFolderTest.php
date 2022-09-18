<?php

use ElaborateCode\JigsawLocalization\Composites\LocaleFolder;
use ElaborateCode\JigsawLocalization\Helpers\File;
use ElaborateCode\JigsawLocalization\Helpers\LocaleFolderFactory;

it('sets locale lang correctly', function () {
    $factory = new LocaleFolderFactory;

    $en = new File('/tests/lang/en');

    $locale = $factory->make($en);

    $this->assertEquals($locale->getLang(), 'en');

    $this->assertFalse($locale->isMulti());
});

it('assertJsonsList', function () {
    $factory = new LocaleFolderFactory;

    $en = new File('/tests/lang/en');

    $locale = $factory->make($en);

    $this->assertArrayHasKey('en.json', $locale->getJsonsList());
});

it('traverses the right amount of locale JSONs', function () {
    $lang_folder = new LocaleFolder(new File('/tests/lang/en'));

    $jsons_counter = 0;
    foreach ($lang_folder as $json_name => $locale_folder) {
        $jsons_counter++;
    }

    $this->assertEquals(3, $jsons_counter);
});
