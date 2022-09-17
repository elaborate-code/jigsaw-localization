<?php

namespace ElaborateCode\JigsawLocalization\Loaders;

use ElaborateCode\JigsawLocalization\Helpers\File;
use Exception;
use TightenCo\Jigsaw\Jigsaw;

class LocaleFolderLoader
{

    protected string $lang;

    protected File $directory;

    private array $jsonsList;

    public function __construct(string $abs_path)
    {
        if (!realpath($abs_path)) {
            throw new Exception("Invalid absolute path '$abs_path' on LocaleFolderLoader instantiation");
        }

        $this->directory = new File($abs_path);

        $this->setLangFromPath();

        $this->setJsonsList();
    }

    protected function setLangFromPath(): void
    {
        $temp = explode(DIRECTORY_SEPARATOR, $this->directory);
        $this->lang = end($temp);
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function isMulti(): bool
    {
        return $this->lang === 'multi';
    }

    protected function setJsonsList(): void
    {
        $this->jsonsList = $this->directory->getDirectoryJsonContent();
    }

    public function getJsonsList(): array
    {
        return $this->jsonsList;
    }

    /* =========================================================*/

    /**
     * - Iterates through the locale folder JSONs' paths list
     * - Decodes each JSON
     * - Adds the newly discovered translations to the site's translations
     */
    public function MergeTranslations(Jigsaw $jigsaw)
    {
        if ($this->isMulti()) {
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
}
