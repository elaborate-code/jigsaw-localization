<?php

namespace ElaborateCode\JigsawLocalization;

use TightenCo\Jigsaw\Jigsaw;

class LoadLocalization
{

    private $langLoader;

    public function __construct()
    {
        $this->langLoader = new LangLoader;
    }

    public function handle(Jigsaw $jigsaw)
    {

        foreach ($this->langLoader->getLocalesLoadersList() as $lang => $localeLoader) {
            $localeLoader->MergeTranslations($jigsaw);
        };

        $this->registerGetCurrentPathLangHelper($jigsaw);
        $this->registerTranslationRetrieverHelper($jigsaw);
    }

    private function registerGetCurrentPathLangHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            'getCurrentPathLang',
            function ($page): string {

                $path = $page->getPath();
                $default_lang = $page->default_lang ?? 'en';

                // Set $lang from path (4 cases)
                if (!str_contains($path, '/')) {
                    // index page
                    if (empty($path))
                        return $default_lang;
                    else
                        return $path;
                } else {
                    $lang = explode('/', $path)[1];

                    // TODO: regex match 'xx' and 'xx_YY' lang codes
                    if (!ctype_lower($lang) || strlen($lang) > 2)
                        $lang = $default_lang;
                }

                return $lang;
            }
        );
    }

    private function registerTranslationRetrieverHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            '__',
            function ($page, string $text, string|null $lang = null): string {

                $lang = $lang ?? $page->getCurrentPathLang();

                if (isset($page->$lang[$text]))
                    return $page->$lang[$text];

                return $text;
            }
        );
    }
}
