<?php

namespace App\Package\LockFile;

use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

class LockFile
{
    private readonly string $path;
    private readonly string $filenameWithoutExtension;
    private readonly string $filename;
    private readonly string $fullPath;
    private bool $isOpen = false;
    private array $data = [];

    public function __construct(string $path, string $filenameWithoutExtension, EntityManagerInterface $manager)
    {
        $this->path = rtrim($path, '/');
        $this->filenameWithoutExtension = $filenameWithoutExtension;
        $this->filename = "{$this->filenameWithoutExtension}.lock";
        $this->fullPath = "{$this->path}/{$this->filename}";
    }

    public function open(): self
    {
        $this->isOpen = true;

        if (false === file_exists($this->fullPath)) {
            $this->data = [];

            file_put_contents($this->fullPath, json_encode($this->data));
        } else {
            $lockContent = file_get_contents($this->fullPath);

            if (empty($lockContent)) {
                $this->data = [];
            } else {
                $this->data = json_decode($lockContent, true);
            }
        }

        return $this;
    }

    public function isOpen(): bool
    {
        return $this->isOpen;
    }

    public function has(string $keys): bool
    {
        $data = $this->getData();
        $keys = explode('.', $keys);

        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                $data = $data[$key];
            } else {
                return false;
            }
        }

        return true;
    }

//    public function addById(string $keysToList, mixed $value)

    public function getData(): array
    {
        if (false === $this->isOpen()) {
            throw new RuntimeException("It is not possible to get data from the {$this->fullPath} local file because it is not open");
        }

        return $this->data;
    }
}