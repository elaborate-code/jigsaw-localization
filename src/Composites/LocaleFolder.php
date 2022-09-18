<?php

namespace ElaborateCode\JigsawLocalization\Composites;

use ElaborateCode\JigsawLocalization\Helpers\File;
use ElaborateCode\JigsawLocalization\LocalizationRepository;
use Exception;

class LocaleFolder
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

    public function loadTranslations(LocalizationRepository $localization_repo)
    {
        foreach ($this->localeJsons as $json_name => $locale_json) {
            $localization_repo->merge($this->lang, $locale_json->getContent());
        }
    }
}
