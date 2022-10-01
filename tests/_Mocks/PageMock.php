<?php

namespace ElaborateCode\JigsawLocalization\Mocks;

use Exception;

class PageMock
{
    protected string $path = '';

    public string $default_locale;

    public array $localization = [];

    public function __construct()
    {
        $this->default_locale = packageDefaultLocale();
    }

    public function setPath(string $path): static
    {
        $this->path = '/'.trim($path, '/');

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

    /**
     *  returns the relative path (i.e. parent directories) of the current page, relative to the site root
     */
    public function getRelativePath()
    {
        throw new Exception('Method not mocked');
    }

    /**
     *  returns the full URL to the item, if baseUrl was defined in config.php
     */
    public function getUrl()
    {
        throw new Exception('Method not mocked');
    }

    /**
     *  returns the filename of the page, without extension (e.g. my-first-page)
     */
    public function getFilename()
    {
        throw new Exception('Method not mocked');
    }

    /**
     *  returns the file extension (e.g. md)
     */
    public function getExtension()
    {
        throw new Exception('Method not mocked');
    }

    /**
     *  returns the last modified time of the file, as a Unix timestamp
     */
    public function getModifiedTime()
    {
        throw new Exception('Method not mocked');
    }
}
