<?php

namespace ElaborateCode\JigsawLocalization;

class LocalizationRepository
{
    protected array $translations = [];

    public function merge(string $lang, array $translations)
    {
        if (isset($this->translations[$lang])) {
            $this->translations[$lang] = $this->translations[$lang] + $translations;
        } else {
            $this->translations[$lang] = $translations;
        }
    }

    public function getTranslations()
    {
        // TODO: return a reference ?
        return $this->translations;
    }
}
