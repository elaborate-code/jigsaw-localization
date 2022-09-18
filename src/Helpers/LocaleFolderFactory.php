<?php

namespace ElaborateCode\JigsawLocalization\Helpers;

use ElaborateCode\JigsawLocalization\Composites\LocaleFolder;

class LocaleFolderFactory
{
    public function make(string $abs_path)
    {
        return new LocaleFolder($abs_path);
    }
}
