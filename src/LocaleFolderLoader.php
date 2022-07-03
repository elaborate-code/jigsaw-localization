<?php

namespace ElaborateCode\JigsawLocalization;

use TightenCo\Jigsaw\Jigsaw;

class LocaleFolderLoader
{
    private string $localeAbsPath;
    private string $lang;
    private bool $isMulti;

    private array $jsonsList;

    public function __construct(string $abs_path, string $lang)
    {
        $this->localeAbsPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $abs_path);
        $this->lang = $lang;
        $this->isMulti = $this->lang === "multi";

        $this->jsonsList = $this->listLocaleFolderJsons($this->localeAbsPath);
    }

    private function listLocaleFolderJsons(string $abs_path): array
    {
        $jsons_list = [];

        $scan_results = scandir($abs_path);

        foreach ($scan_results as $json) {
            if ($this->is_not_json($json)) {
                continue;
            }

            $jsons_list[] = $this->localeAbsPath . DIRECTORY_SEPARATOR . $json;
        }

        return $jsons_list;
    }

    /* =========================================================*/

    /**
     * - Iterates through the locale folder JSONs' paths list
     * - Decodes each JSON
     * - Adds the newly discovered translations to the site's translations
     */
    public function MergeTranslations(Jigsaw $jigsaw)
    {
        if ($this->isMulti) {
            foreach ($this->jsonsList as $json) {

                $multi_translations = $this->decoded_json($json);

                foreach ($multi_translations as $lang => $translations) {
                    $this->pushTranslations($jigsaw, $translations, $lang);
                }
            }
        } else {
            foreach ($this->jsonsList as $json) {

                $lang_translations = $this->decoded_json($json);

                $this->pushTranslations($jigsaw, $lang_translations, $this->lang);
            }
        }
    }

    private function pushTranslations(Jigsaw $jigsaw, array $translations, string $lang)
    {
        $jigsaw->setConfig(
            $lang,
            ($jigsaw->getConfig($lang)?->toArray() ?? [])
                + $translations
        );
    }

    /* ---------------------------------------------------------*/
    //          Helpers
    /* ---------------------------------------------------------*/

    private function decoded_json(string $abs_path): array
    {
        return json_decode(file_get_contents($abs_path), true);
    }

    /**
     * Checks the end of file or path and matches it against '.json'
     */
    private function is_not_json(string $path): bool
    {
        return substr($path, -5) !== ".json";
    }

    /* ---------------------------------------------------------*/
    //          Setters and Getters
    /* ---------------------------------------------------------*/

    public function getJsonsList(): array
    {
        return $this->jsonsList;
    }
}
