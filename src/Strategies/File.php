<?php

namespace ElaborateCode\JigsawLocalization\Strategies;

use Stringable;

class File implements Stringable
{
    /**
     * Realpath
     */
    protected string $projectRoot;

    /**
     * Realpath
     */
    protected string $path;

    protected bool $isDir;

    /**
     * 'file_name' => 'file_absolute_path'
     */
    protected array $directoryContent;

    public function __construct(string $rel_path = '')
    {
        $this->setProjectRoot();

        $this->setPath($rel_path);

        $this->isDir = is_dir($this->path);

        if ($this->isDir()) {
            $files = scandir($this->path);
            $files = array_splice($files, 2);

            $this->directoryContent = [];

            foreach ($files as $file_name) {
                $this->directoryContent[$file_name] = realpath($this->path.DIRECTORY_SEPARATOR.$file_name);
            }
        }
    }

    public function __toString(): string
    {
        return $this->path;
    }

    /* =================================== */
    //
    /* =================================== */

    protected function setProjectRoot(): void
    {
        $reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);

        $this->projectRoot = realpath(dirname($reflection->getFileName(), 3));
    }

    protected function setPath(string $rel_path): void
    {
        $is_valid_abs_path = realpath($rel_path);

        if ($is_valid_abs_path) {
            $this->path = $is_valid_abs_path;

            return;
        }

        $realpath = realpath($this->projectRoot.DIRECTORY_SEPARATOR.$rel_path);

        if (! $realpath) {
            throw new \Exception("Invalid relative path. Can't get absolute path from '$rel_path'!");
        }

        $this->path = $realpath;
    }

    /* =================================== */
    //
    /* =================================== */

    /**
     * 'File_name' => 'file_absolute_path'
     */
    public function getDirectoryContent(): array
    {
        if (! $this->isDir()) {
            throw new \Exception("This object isn't a directory");
        }

        return $this->directoryContent;
    }

    /**
     * 'JSON_name' => 'file_absolute_path'
     */
    public function getDirectoryJsonContent(): array
    {
        if (! $this->isDir()) {
            throw new \Exception("This object isn't a directory");
        }

        return array_filter(
            $this->directoryContent,
            fn ($file_name, $abs_path) => is_json($file_name),
            ARRAY_FILTER_USE_BOTH
        );
    }

    /* =================================== */
    //          Simple getters
    /* =================================== */

    public function isDir(): bool
    {
        return $this->isDir;
    }

    public function getProjectRoot(): string
    {
        return $this->projectRoot;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
