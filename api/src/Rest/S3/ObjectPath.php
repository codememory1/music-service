<?php

namespace App\Rest\S3;

final class ObjectPath
{
    private ?string $path = null;

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getBucket(): ?string
    {
        if (null !== $this->path) {
            return explode('/', $this->path)[0];
        }

        return null;
    }

    public function getKey(): ?string
    {
        if (null !== $this->path) {
            return mb_substr($this->path, mb_strpos($this->path, '/') + 1);
        }

        return null;
    }
}