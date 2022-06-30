<?php

namespace ElaborateCode\JigsawLocalization;

class LangLoader
{
    private string $projectRoot;
    private array $localesList;
    private array $localesLoadersList = [];

    public function __construct()
    {
        $this->setProjectRoot(); // TODO turn to function project_root():string
        $this->localesList = $this->listLocalesFolders();

        foreach ($this->localesList as $lang) {
            $this->localesLoadersList[$lang] = new LocaleFolderLoader($this->projectRoot . "\\lang\\$lang", $lang);
        }
    }

    /**
     * 
     */
    private function listLocalesFolders(): array
    {
        if (!realpath($this->projectRoot . '\\lang')) {
            trigger_error("No lang folder found", E_USER_NOTICE);
            return [];
        }

        $scan_results = scandir($this->getRealpath('\\lang'));
        // Exclude '.' and '..'
        return array_splice($scan_results, 2);
    }

    /* ---------------------------------------------------------*/
    //          Helpers
    /* ---------------------------------------------------------*/

    /**
     * Assume that the vendor folder is in the project root
     */
    private function setProjectRoot(): void
    {
        $reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);
        $this->projectRoot = realpath(dirname($reflection->getFileName(), 3));
    }

    /**
     * @return string valid absolute path
     * @throws \Exception if path is invalid
     */
    private function getRealpath(string $rel_path): string
    {
        $realpath = realpath($this->projectRoot . "\\$rel_path");

        if (!$realpath)
            throw new \Exception("Invalid relative path. Can't get absolute path from '$rel_path'!", 1);

        return $realpath;
    }

    /* ---------------------------------------------------------*/
    //          Setters and Getters
    /* ---------------------------------------------------------*/

    public function getLocalesList(): array
    {
        return $this->localesList;
    }

    public function getLocalesLoadersList()
    {
        return $this->localesLoadersList;
    }
}
