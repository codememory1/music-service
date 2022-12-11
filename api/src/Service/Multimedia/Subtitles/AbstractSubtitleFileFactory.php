<?php

namespace App\Service\Multimedia\Subtitles;

use App\Service\Multimedia\Subtitles\Interfaces\MultimediaSubtitlesFileInterface;
use Captioning\File;
use Exception;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

abstract class AbstractSubtitleFileFactory implements MultimediaSubtitlesFileInterface
{
    protected readonly ?File $file;

    /**
     * @throws ClassNotFoundException
     */
    public function __construct(
        protected readonly string $path,
        protected readonly ?string $encoding = null,
        protected readonly bool $useIconv = false,
        protected readonly bool $requireStrictFileFormat = true
    ) {
        if (false === class_exists($this->getFormat())) {
            throw new ClassNotFoundException($this->getFormat());
        }

        try {
            $this->file = new ($this->getFormat())($path, $encoding, $useIconv, $requireStrictFileFormat);
        } catch (Exception) {
            $this->file = null;
        }
    }

    abstract protected function getFormat(): string;

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function isValidated(): bool
    {
        return null !== $this->file;
    }
}