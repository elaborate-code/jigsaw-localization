<?php

namespace ElaborateCode\JigsawLocalization\Factories;

use ElaborateCode\JigsawLocalization\Composites\LocaleFolder;
use ElaborateCode\JigsawLocalization\Composites\MultiLocaleFolder;
use ElaborateCode\JigsawLocalization\Contracts\LocaleFolderLoader;

class LocaleFolderFactory
{
    public function make(string $abs_path): LocaleFolderLoader
    {
        if (strcmp(strtolower(basename($abs_path)), 'multi') === 0) {
            return new MultiLocaleFolder($abs_path);
        } else {
            return new LocaleFolder($abs_path);
        }
    }
}
