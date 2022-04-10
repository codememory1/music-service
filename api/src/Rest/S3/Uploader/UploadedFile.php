<?php

namespace App\Rest\S3\Uploader;

use ArrayIterator;

/**
 * Class UploadedFile.
 *
 * @package App\Rest\S3\Uploader
 *
 * @author  Codememory
 */
class UploadedFile
{
    /**
     * @var array
     */
    private array $paths;

    /**
     * @param array $paths
     */
    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    /**
     * @return null|string
     */
    public function first(): ?string
    {
        return $this->paths[0] ?? null;
    }

    /**
     * @return null|string
     */
    public function last(): ?string
    {
        $lastKey = array_key_last($this->paths);

        return null === $lastKey ? null : $this->paths[$lastKey];
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->paths;
    }

    /**
     * @return ArrayIterator
     */
    public function iterator(): ArrayIterator
    {
        return new ArrayIterator($this->paths);
    }
}