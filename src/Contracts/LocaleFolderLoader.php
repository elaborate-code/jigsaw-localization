<?php

namespace ElaborateCode\JigsawLocalization\Contracts;

use ElaborateCode\JigsawLocalization\LocalizationRepository;

interface LocaleFolderLoader
{
    public function loadTranslations(LocalizationRepository $localization_repo);
}
