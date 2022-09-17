<?php

namespace ElaborateCode\JigsawLocalization\Helpers;

use ElaborateCode\JigsawLocalization\Loaders\LocaleFolderLoader;

class LocaleFolderLoaderFactory
{
    public function make(string $abs_path, string $lang)
    {
        return new LocaleFolderLoader($abs_path, $lang);
    }
}
