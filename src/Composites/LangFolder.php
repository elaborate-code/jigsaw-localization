<?php

namespace ElaborateCode\JigsawLocalization\Composites;

use ElaborateCode\JigsawLocalization\Helpers\File;
use ElaborateCode\JigsawLocalization\Helpers\LocaleFolderFactory;
use ElaborateCode\JigsawLocalization\Localization;
use Iterator;
use ReturnTypeWillChange;

class LangFolder implements Iterator
{
    protected File $directory;

    protected LocaleFolderFactory $localeFolderFactory;

    /**
     * @var array<LocaleFolder> 'lang_code' => LocaleFolder instance
     */
    protected array $localesList;

    /**
     * @param string $lang_path Lang directory path from the project root
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

    public function mergeTranslations(Localization $localization): void
    {
        foreach ($this->localesList as $lang => $localeFolder) {
            $localeFolder->pushTranslations($localization);
        }
    }

    /* ---------------------------------------------------------*/
    //
    /* ---------------------------------------------------------*/
    public function rewind(): void
    {
        reset($this->localesList);
    }

    #[ReturnTypeWillChange]
    public function current()
    {
        return current($this->localesList);
    }

    #[ReturnTypeWillChange]
    public function key()
    {
        return key($this->localesList);
    }

    public function next(): void
    {
        next($this->localesList);
    }

    public function valid(): bool
    {
        return !is_null(key($this->localesList));
    }
}
