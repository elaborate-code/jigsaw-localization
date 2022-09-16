<?php

namespace ElaborateCode\JigsawLocalization\Loaders;

use ElaborateCode\JigsawLocalization\Helpers\File;

class LangLoader
{
    protected File $langDirectory;

    protected array $localesList;

    protected array $localesLoadersList = [];

    public function __construct(string $lang_path = 'lang')
    {
        $this->langDirectory = new File($lang_path);

        $this->setLocalesList();

        $this->setLocalesLoadersList();
    }

    public function setLocalesList(): void
    {
        $this->localesList = $this->langDirectory->getDirectoryContent();
    }

    public function getLocalesList(): array
    {
        return $this->localesList;
    }

    public function setLocalesLoadersList(): void
    {
        foreach ($this->localesList as $lang => $abs_path) {
            // ! INJECT
            $this->localesLoadersList[$lang] = new LocaleFolderLoader($abs_path, $lang);
        }
    }

    public function getLocalesLoadersList(): array
    {
        return $this->localesLoadersList;
    }
}
