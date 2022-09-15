<?php

namespace ElaborateCode\JigsawLocalization\Helpers;

use Stringable;

class Folder implements Stringable
{

    protected string $projectRoot;

    protected string $path;

    public function __construct(string $rel_path = '')
    {
        $this->setProjectRoot();
        $this->setPath($rel_path);
    }

    public function __toString(): string
    {
        return $this->path;
    }

    public function setProjectRoot(): void
    {
        $reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);

        $this->projectRoot = realpath(dirname($reflection->getFileName(), 3));
    }

    public function getProjectRoot(): string
    {
        return $this->projectRoot;
    }

    public function setPath(string $rel_path): void
    {
        $this->path = realpath($this->projectRoot . DIRECTORY_SEPARATOR . $rel_path);
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
