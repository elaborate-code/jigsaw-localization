<?php

namespace ElaborateCode\JigsawLocalization\Composites;

use ElaborateCode\JigsawLocalization\Helpers\File;
use Exception;
use Iterator;
use ReturnTypeWillChange;
use TightenCo\Jigsaw\Jigsaw;

class LocaleFolder implements Iterator
{
    protected File $directory;

    protected string $lang;

    protected array $jsonsList;

    /**
     * @var array<LocaleJson>
     */
    protected array $localeJsons;

    public function __construct(string $abs_path)
    {
        if (! realpath($abs_path) || ! is_dir($abs_path)) {
            throw new Exception("Invalid absolute folder path '$abs_path' on LocaleFolder instantiation");
        }

        $this->directory = new File($abs_path);

        $this->setLangFromPath();

        $this->setJsonsList();

        $this->setJsons();
    }

    protected function setLangFromPath(): void
    {
        $this->lang = basename($this->directory->getPath());
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

    public function setJsons()
    {
        $this->localeJsons = [];

        foreach ($this->jsonsList as $file_name => $abs_path) {
            $this->localeJsons[$file_name] = new LocaleJson($abs_path);
        }
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

    private function decoded_json(string $abs_path): array
    {
        return json_decode(file_get_contents($abs_path), true);
    }

    /* ---------------------------------------------------------*/
    //
    /* ---------------------------------------------------------*/
    public function rewind(): void
    {
        reset($this->localeJsons);
    }

    #[ReturnTypeWillChange]
    public function current()
    {
        return current($this->localeJsons);
    }

    #[ReturnTypeWillChange]
    public function key()
    {
        return key($this->localeJsons);
    }

    public function next(): void
    {
        next($this->localeJsons);
    }

    public function valid(): bool
    {
        return ! is_null(key($this->localeJsons));
    }
}
