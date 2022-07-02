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

        $this->registerCurrentPathLangHelper($jigsaw);
        $this->registerTranslationRetrieverHelper($jigsaw);
        $this->registerTranslatedRouteHelper($jigsaw);
        $this->registerLangRouteHelper($jigsaw);
    }

    private function registerCurrentPathLangHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            'currentPathLang',
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

                $lang = $lang ?? $page->currentPathLang();

                if (isset($page->$lang[$text]))
                    return $page->$lang[$text];

                return $text;
            }
        );
    }

    private function registerTranslatedRouteHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            'translated_route',
            function ($page, string $trans_lang, string|null $current_lang = null): string {
                $href = '';
                $current_lang ??= $page->currentPathLang();

                if ($current_lang === $page->default_lang) {
                    // "default_lang" isn't shown at the beginning of the URL
                    // So just prefix the translation lang "/YY"
                    $href = "/$trans_lang" . $page->getPath();
                } else {
                    // Remove the lang prefix "/XX"
                    // prefix the translation lang "/YY"
                    $href = "/$trans_lang" . substr($page->getPath(), 3);
                }

                if (str_starts_with($href, '/' . $page->default_lang))
                    $href = substr($href, 3);

                if (empty($href)) {
                    return '/';
                }

                return $href;
            }
        );
    }

    private function registerLangRouteHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            'lang_route',
            function ($page, $url, string|null $current_lang = null): string {

                $current_lang ??= $page->currentPathLang();

                if ($url[0] !== '/')
                    $url = '/' . $url;

                if ($current_lang === $page->default_lang) {
                    return $url;
                } else {
                    return "/$current_lang" . $url;
                }
            }
        );
    }
}
