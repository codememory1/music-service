<?php

namespace App\Rest\S3\Uploader;

use ArrayIterator;

class UploadedFile
{
    private array $paths;

    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    public function first(): ?string
    {
        return $this->paths[0] ?? null;
    }

    public function last(): ?string
    {
        $lastKey = array_key_last($this->paths);

        return null === $lastKey ? null : $this->paths[$lastKey];
    }

    public function all(): array
    {
        return $this->paths;
    }

    public function iterator(): ArrayIterator
    {
        return new ArrayIterator($this->paths);
    }
}