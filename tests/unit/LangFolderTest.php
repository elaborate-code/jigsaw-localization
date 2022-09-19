<?php

use ElaborateCode\JigsawLocalization\Composites\LangFolder;
use ElaborateCode\JigsawLocalization\Strategies\File;

it('lists available locales correctly', function () {
    $lang_folder = new LangFolder('/tests/lang');

    $this->assertContains('ar', $lang_folder->getLocalesList());
    $this->assertContains('en', $lang_folder->getLocalesList());
    $this->assertContains('es', $lang_folder->getLocalesList());
    $this->assertContains('fr', $lang_folder->getLocalesList());
});

// it('traverses the right amount of locale folders', function () {
//     $lang_folder = new LangFolder(new File('/tests/lang'));

//     $locales_counter = 0;
//     foreach ($lang_folder as $json_name => $locale_folder) {
//         $locales_counter++;
//     }

//     $this->assertEquals(4, $locales_counter);
// });
