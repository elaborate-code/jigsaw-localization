<?php

namespace ElaborateCode\JigsawLocalization\Factories;

use ElaborateCode\JigsawLocalization\Composites\LocaleFolder;
use ElaborateCode\JigsawLocalization\Contracts\LocaleFolderLoader;

class LocaleFolderFactory
{
    public function make(string $abs_path): LocaleFolderLoader
    {
        return new LocaleFolder($abs_path);

        // TODO: may return a MultiLocaleFolder
    }
}
