<?php

namespace ElaborateCode\JigsawLocalization\Composites;

use ElaborateCode\JigsawLocalization\Contracts\LocaleFolderLoader;
use ElaborateCode\JigsawLocalization\LocalizationRepository;

class MultiLocaleFolder extends LocaleFolderLoader
{
    /* =================================== */
    //             Interface
    /* =================================== */

    public function loadTranslations(LocalizationRepository $localization_repo): void
    {
        foreach ($this->localeJsons as $json_name => $multi_locale_json) {
            foreach ($multi_locale_json->getContent() as $lang => $locale) {
                $localization_repo->merge($lang, $locale);
            }
        }
    }
}
