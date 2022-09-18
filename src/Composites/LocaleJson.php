<?php

namespace ElaborateCode\JigsawLocalization\Composites;

use ElaborateCode\JigsawLocalization\Helpers\File;
use Exception;

class LocaleJson
{
    protected File $json;

    protected null|array $content = [];

    public function __construct(string $abs_path)
    {
        if (! realpath($abs_path)) {
            throw new Exception("Invalid absolute JSON path '$abs_path' on LocaleFolder instantiation");
        }

        $this->json = new File($abs_path);

        $this->content = json_decode(file_get_contents($this->json->getPath()), true);

        // TODO: It is possible to throw an exception when a JSON is empty or invalid
        $this->content ??= [];
    }

    public function getContent(): array
    {
        return $this->content;
    }
}
