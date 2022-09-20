<?php

namespace ElaborateCode\JigsawLocalization\Composites;

use ElaborateCode\JigsawLocalization\Contracts\LangFolderLoader;
use ElaborateCode\JigsawLocalization\Contracts\LocaleFolderLoader;
use ElaborateCode\JigsawLocalization\Factories\LocaleFolderFactory;
use ElaborateCode\JigsawLocalization\LocalizationRepository;
use ElaborateCode\JigsawLocalization\Strategies\File;

final class LangFolder implements LangFolderLoader
{
    protected File $directory;

    protected LocaleFolderFactory $localeFolderFactory;

    /**
     * @var array<LocaleFolderLoader> 'lang_code' => LocaleFolderLoader instance
     */
    protected array $localesList;

    /**
     * @param  string  $lang_path Lang directory path from the project root
     */
    public function __construct(string $lang_path = '/lang')
    {
        // ! IOC
        $this->directory = new File($lang_path);

        // ! IOC
        $this->localeFolderFactory = new LocaleFolderFactory;

        $this->setLocales();
    }

    /* =================================== */
    //             Interface
    /* =================================== */

    public function orderLoadingTranslations(LocalizationRepository $localization_repo): void
    {
        foreach ($this->localesList as $lang => $localeFolder) {
            $localeFolder->loadTranslations($localization_repo);
        }
    }

    /* =================================== */
    //          Setters
    /* =================================== */

    protected function setLocales(): void
    {
        $this->localesList = [];

        foreach ($this->directory->getDirectoryContent() as $lang => $abs_path) {
            $this->localesList[$lang] = $this->localeFolderFactory->make($abs_path);
        }
    }

    /* =================================== */
    //          Simple getters
    /* =================================== */

    public function getLocalesList(): array
    {
        return array_keys($this->directory->getDirectoryContent());
    }

    public function getLocales(): array
    {
        return $this->localesList;
    }
}
