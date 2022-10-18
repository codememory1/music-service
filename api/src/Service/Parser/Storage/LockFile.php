<?php

namespace App\Service\Parser\Storage;

class LockFile
{
    private array $lockData;

    public function __construct(
        private readonly string $parserName,
        private readonly string $path
    ) {
        if (false === file_exists($this->path)) {
            $this->lockData = [
                $this->parserName => []
            ];

            file_put_contents($this->path, json_encode($this->lockData));
        } else {
            $lockContent = file_get_contents($this->path);
            
            if (empty($lockContent)) {
                $this->lockData = [$this->parserName => []];
            } else {
                $this->lockData = json_decode($lockContent, true);
                
                if (false === array_key_exists($this->parserName, $this->lockData)) {
                    $this->lockData[$this->parserName] = [];
                }
            }
        }
    }

    public function change(callable $callback): self
    {
        call_user_func_array($callback, [&$this->lockData[$this->parserName]]);

        file_put_contents($this->path, json_encode($this->lockData));

        return $this;
    }

    public function getLockData(): array
    {
        return $this->lockData[$this->parserName];
    }
}