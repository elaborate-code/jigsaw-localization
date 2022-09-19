<?php

namespace ElaborateCode\JigsawLocalization\Composites;

use ElaborateCode\JigsawLocalization\Contracts\LocaleJsonLoader;
use ElaborateCode\JigsawLocalization\Strategies\File;
use Exception;

final class LocaleJson implements LocaleJsonLoader
{
    protected File $json;

    protected array $content = [];

    public function __construct(string $abs_path)
    {
        if (! realpath($abs_path)) {
            throw new Exception("Invalid absolute JSON path '$abs_path' on LocaleFolder instantiation");
        }

        // ! IOC
        $this->json = new File($abs_path);

        // TODO: It is possible to throw an exception when a JSON is empty or invalid
        $this->content = json_decode(file_get_contents($this->json->getPath()), true) ?? [];
    }

    /* =================================== */
    //
    /* =================================== */

    public function getContent(): array
    {
        return $this->content;
    }
}
