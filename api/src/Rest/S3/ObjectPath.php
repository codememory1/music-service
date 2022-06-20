<?php

namespace App\Rest\S3;

/**
 * Class ObjectPath.
 *
 * @package App\Rest\S3
 *
 * @author  Codememory
 */
class ObjectPath
{
    /**
     * @var null|string
     */
    private ?string $path = null;

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBucket(): ?string
    {
        if (null !== $this->path) {
            return explode('/', $this->path)[0];
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function getKey(): ?string
    {
        if (null !== $this->path) {
            return mb_substr($this->path, mb_strpos($this->path, '/'));
        }

        return null;
    }
}