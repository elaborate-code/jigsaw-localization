<?php

namespace ElaborateCode\JigsawLocalization\Contracts;

use ElaborateCode\JigsawLocalization\Composites\LocaleJson;
use ElaborateCode\JigsawLocalization\LocalizationRepository;
use ElaborateCode\JigsawLocalization\Strategies\File;
use Exception;

abstract class LocaleFolderLoader
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

        // ! IOC
        $this->directory = new File($abs_path);

        $this->setLangFromPath();

        $this->setJsonsList();

        $this->setJsons();
    }

    /* =================================== */
    //          Interface
    /* =================================== */

    abstract public function loadTranslations(LocalizationRepository $localization_repo): void;

    /* =================================== */
    //          Setters
    /* =================================== */

    protected function setLangFromPath(): void
    {
        //
        $this->lang = basename($this->directory->getPath());
    }

    protected function setJsonsList(): void
    {
        $this->jsonsList = $this->directory->getDirectoryJsonContent();
    }

    protected function setJsons()
    {
        $this->localeJsons = [];

        foreach ($this->jsonsList as $file_name => $abs_path) {
            // ! IOC
            $this->localeJsons[$file_name] = new LocaleJson($abs_path);
        }
    }

    /* =================================== */
    //          Simple getters
    /* =================================== */

    public function getLang(): string
    {
        return $this->lang;
    }

    public function getJsonsList(): array
    {
        return $this->jsonsList;
    }
}
