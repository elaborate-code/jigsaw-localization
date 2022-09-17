<?php

namespace ElaborateCode\JigsawLocalization\Loaders;

use ElaborateCode\JigsawLocalization\Helpers\File;
use ElaborateCode\JigsawLocalization\Helpers\LocaleFolderLoaderFactory;

class LangFolderLoader
{
    protected File $langDirectory;

    protected array $localesLoadersList = [];

    protected LocaleFolderLoaderFactory $localeFolderLoaderFactory;

    public function __construct(string $lang_path = 'lang')
    {
        $this->localeFolderLoaderFactory = new LocaleFolderLoaderFactory;

        $this->langDirectory = new File($lang_path);

        $this->setLocalesLoadersList();
    }

    public function getLocalesList(): array
    {
        return array_keys($this->langDirectory->getDirectoryContent());
    }

    public function setLocalesLoadersList(): void
    {
        foreach ($this->langDirectory->getDirectoryContent() as $lang => $abs_path) {
            // ! INJECT
            $this->localesLoadersList[$lang] = $this->localeFolderLoaderFactory->make($abs_path, $lang);
        }
    }

    public function getLocalesLoadersList(): array
    {
        return $this->localesLoadersList;
    }
}
