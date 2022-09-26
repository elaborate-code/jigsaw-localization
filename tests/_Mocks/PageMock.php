<?php

namespace ElaborateCode\JigsawLocalization\Mocks;

class PageMock
{
    public array $localization = [];

    public function setLocalization(array $localization): static
    {
        $this->localization = $localization;

        return $this;
    }
}
