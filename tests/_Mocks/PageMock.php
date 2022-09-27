<?php

namespace ElaborateCode\JigsawLocalization\Mocks;

use Exception;

class PageMock
{
    protected string $path = '';

    public array $localization = [];

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function setLocalization(array $localization): static
    {
        $this->localization = $localization;

        return $this;
    }

    /* =================================== */
    //             Mocked methods
    /* =================================== */

    /**
     * returns the path to the current page, relative to the site root
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
