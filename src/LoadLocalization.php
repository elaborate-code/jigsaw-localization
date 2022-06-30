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

        $this->registerTranslationRetrieverHelper($jigsaw);
    }

    private function registerTranslationRetrieverHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            '__',
            function ($page, string $text, string|null $lang = null): string {

                if (!$lang) {

                    $path = $page->getPath();
                    $default_lang = $page->default_lang ?? 'en';

                    // Set $lang from path (4 cases)
                    if (!str_contains($path, '/')) {
                        // index page
                        if (empty($path))
                            $lang = $default_lang;
                        else
                            $lang = $path;
                    } else {
                        $lang = explode('/', $path)[1];

                        // TODO: regex match 'xx' and 'xx_YY' lang codes
                        if (!ctype_lower($lang) || strlen($lang) > 2)
                            $lang = $default_lang;
                    }
                }

                if (isset($page->$lang[$text]))
                    return $page->$lang[$text];

                return $text;
            }
        );
    }
}
