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
        $this->registerUrlHelper($jigsaw);
    }

    private function registerTranslationRetrieverHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            '__',
            function ($page, string $text, string|null $current_lang = null): string {

                $current_lang ??= $page->current_path_lang();

                return isset($page->$current_lang[$text]) ?
                    $page->$current_lang[$text] :
                    $text;
            }
        );
    }

    private function registerCurrentPathLangHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            'current_path_lang',
            /**
             * ! This helper relies on the language prefix folder structure
             */
            function ($page): string {

                $path = $page->getPath();
                $default_lang = $page->default_lang ?? 'en';

                // Set $lang from path (4 cases)
                if (!str_contains($path, '/')) {
                    // index page
                    if (empty($path)) {
                        return $default_lang;
                    } else {
                        return $path;
                    }
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

    private function registerTranslatedRouteHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            'translated_route',
            /**
             * ! This helper relies on the language prefix folder structure
             */
            function ($page, string $trans_lang, string|null $current_lang = null): string {
                $href = '';
                $current_lang ??= $page->current_path_lang();

                if ($current_lang === $page->default_lang) {
                    // "default_lang" isn't shown at the beginning of the URL
                    // So just prefix the translation lang "/YY"
                    $href = "/$trans_lang" . $page->getPath();
                } else {
                    // Remove the lang prefix "/XX"
                    // prefix the translation lang "/YY"
                    $href = "/$trans_lang" . substr($page->getPath(), 3);
                }

                if (str_starts_with($href, '/' . $page->default_lang)) {
                    $href = substr($href, 3);
                }

                if (empty($href)) {
                    return $page->url('/');
                }

                return $page->url($href);
            }
        );
    }

    private function registerLangRouteHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            'lang_route',
            /**
             * ! This helper relies on the language prefix folder structure
             */
            function ($page, string $partial_path, string|null $current_lang = null): string {

                $current_lang ??= $page->current_path_lang();

                if (!str_starts_with($partial_path, '/')) {
                    $partial_path = '/' . $partial_path;
                }

                if ($current_lang === $page->default_lang) {
                    return $page->url($partial_path);
                } else {
                    return $page->url("/$current_lang" . $partial_path);
                }
            }
        );
    }

    private function registerUrlHelper(Jigsaw $jigsaw)
    {
        $jigsaw->setConfig(
            'url',
            /**
             * Generates a fully qualified URL to the given path.
             */
            function ($page, string $path): string {

                $baseUrl = $page->baseUrl ?? '';

                if (!str_ends_with($baseUrl, '/')) {
                    $baseUrl .= "/";
                }

                if (str_starts_with($path, "/")) {
                    $path = substr($path, 1);
                }

                return $baseUrl . $path;
            }
        );
    }
}
