<?php

namespace ElaborateCode\JigsawLocalization\Composites;

use ElaborateCode\JigsawLocalization\Helpers\File;
use ElaborateCode\JigsawLocalization\Helpers\LocaleFolderFactory;

class LangFolder
{
    protected File $directory;

    /**
     * @var array<LocaleFolder>
     */
    protected array $localesList;

    protected LocaleFolderFactory $localeFolderFactory;

    /**
     * Lang path from the project root
     */
    public function __construct(string $lang_path = '/lang')
    {
        $this->directory = new File($lang_path);

        // ! INJECT
        $this->localeFolderFactory = new LocaleFolderFactory;

        $this->setLocales();
    }

    public function getLocalesList(): array
    {
        return array_keys($this->directory->getDirectoryContent());
    }

    protected function setLocales(): void
    {
        $this->localesList = [];

        foreach ($this->directory->getDirectoryContent() as $lang => $abs_path) {
            $this->localesList[$lang] = $this->localeFolderFactory->make($abs_path);
        }
    }

    public function getLocales(): array
    {
        return $this->localesList;
    }
}
