<?php

namespace ElaborateCode\JigsawLocalization;

use TightenCo\Jigsaw\Jigsaw;

class LocalizationLoader
{

    public function __construct(private LangLoader $langLoader)
    {
    }

    public function handle(Jigsaw $jigsaw)
    {

        foreach ($this->langLoader->getLocalesLoadersList() as $lang => $localeLoader) {
            $localeLoader->MergeTranslations($jigsaw);
        };
    }
}
