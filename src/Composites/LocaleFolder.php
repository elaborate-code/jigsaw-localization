<?php

namespace ElaborateCode\JigsawLocalization\Composites;

use ElaborateCode\JigsawLocalization\Contracts\LocaleFolderLoader;
use ElaborateCode\JigsawLocalization\LocalizationRepository;

class LocaleFolder extends LocaleFolderLoader
{
    /* =================================== */
    //             Interface
    /* =================================== */

    public function loadTranslations(LocalizationRepository $localization_repo): void
    {
        foreach ($this->localeJsons as $json_name => $locale_json) {
            $localization_repo->merge($this->lang, $locale_json->getContent());
        }
    }
}
