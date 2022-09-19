<?php

namespace ElaborateCode\JigsawLocalization\Contracts;

use ElaborateCode\JigsawLocalization\LocalizationRepository;

interface LangFolderLoader
{
    public function orderLoadingTranslations(LocalizationRepository $localization_repo): void;
}
