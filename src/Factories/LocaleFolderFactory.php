<?php

namespace ElaborateCode\JigsawLocalization\Factories;

use ElaborateCode\JigsawLocalization\Composites\LocaleFolder;

class LocaleFolderFactory
{
    public function make(string $abs_path): LocaleFolder
    {
        return new LocaleFolder($abs_path);
    }
}
