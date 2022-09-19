<?php

namespace ElaborateCode\JigsawLocalization\Concerns;

use ReturnTypeWillChange;

// * implements Iterator

trait TraversableAssocArray
{
    public array $assocArrayProperty;

    public function rewind(): void
    {
        reset($this->assocArrayProperty);
    }

    #[ReturnTypeWillChange]
    public function current()
    {
        return current($this->assocArrayProperty);
    }

    #[ReturnTypeWillChange]
    public function key()
    {
        return key($this->assocArrayProperty);
    }

    public function next(): void
    {
        next($this->assocArrayProperty);
    }

    public function valid(): bool
    {
        return ! is_null(key($this->assocArrayProperty));
    }
}
