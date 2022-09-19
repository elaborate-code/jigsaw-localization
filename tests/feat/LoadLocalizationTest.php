<?php

use ElaborateCode\JigsawLocalization\Composites\LangFolder;
use ElaborateCode\JigsawLocalization\LocalizationRepository;

it('complete', function () {
    $langLoader = new LangFolder('/tests/lang');

    $localizationRepo = new LocalizationRepository;

    $langLoader->orderLoadingTranslations($localizationRepo);

    $this->assertCount(3, $localizationRepo->getTranslations());
    $this->assertArrayHasKey('ar', $localizationRepo->getTranslations());
    $this->assertArrayHasKey('en', $localizationRepo->getTranslations());
    $this->assertArrayHasKey('fr', $localizationRepo->getTranslations());

    $this->assertCount(0, $localizationRepo->getTranslations()['ar']);
    $this->assertCount(5, $localizationRepo->getTranslations()['en']);
});
