<?php

namespace App\Service;

use JetBrains\PhpStorm\ArrayShape;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class FileUploaderService
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class FileUploaderService
{

    /**
     * @var FileBag
     */
    private FileBag $fileBag;

    /**
     * @var ContainerBag
     */
    private ContainerBag $parameters;

    /**
     * @var string|null
     */
    private ?string $saveTo = null;

    /**
     * @var array
     */
    private array $uploadedFile = [];

    /**
     * @var UploadedFile|null
     */
    private ?UploadedFile $file = null;

    /**
     * @param FileBag      $fileBag
     * @param ContainerBag $parameters
     */
    public function __construct(FileBag $fileBag, ContainerBag $parameters)
    {

        $this->fileBag = $fileBag;
        $this->parameters = $parameters;

    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setSaveTo(string $path): FileUploaderService
    {

        $this->saveTo = $path;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getSaveTo(): ?string
    {

        return $this->saveTo;

    }

    /**
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getAbsoluteSaveTo(): string
    {

        $kernelProjectDir = rtrim($this->parameters->get('kernel.project_dir'), '/');

        return sprintf('%s/%s', $kernelProjectDir, rtrim($this->saveTo, '/'));

    }

    /**
     * @return array
     */
    public function getUploadedFile(): array
    {

        return $this->uploadedFile;

    }
    /**
     * @param string $requestFileName
     *
     * @return FileUploaderService
     */
    public function initRequestFile(string $requestFileName): FileUploaderService
    {

        $this->file = $this->fileBag->get($requestFileName);

        return $this;

    }

    /**
     * @return UploadedFile|null
     */
    public function getInitializedRequestFile(): ?UploadedFile
    {

        return $this->file;

    }

    /**
     * @param callable|null $handlerFilename
     *
     * @return $this
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function upload(?callable $handlerFilename = null): FileUploaderService
    {

        if (null !== $this->file) {
            $filename = $this->file->getClientOriginalName();

            if (null !== $handlerFilename) {
                $extension = $this->getExtensionFromFilename($filename);
                $filenameWithoutExtension = $this->getFilenameWithoutExtension($filename);

                $filename = call_user_func($handlerFilename, $filenameWithoutExtension) . $extension;
            }

            $this->file->move($this->getAbsoluteSaveTo(), $filename);

            $this->uploadedFile = $this->schemaUploadedFile($filename);
        }

        return $this;

    }

    /**
     * @param string $filename
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[ArrayShape([
        'filename'                    => "string",
        'filename_without_extension'  => "false|string",
        'filename_with_absolute_path' => "string",
        'filename_with_path'          => "string"
    ])]
    private function schemaUploadedFile(string $filename): array
    {

        return [
            'filename'                    => $filename,
            'filename_without_extension'  => $this->getFilenameWithoutExtension($filename),
            'filename_with_absolute_path' => $this->getAbsoluteSaveTo() . '/' . $filename,
            'filename_with_path'          => $this->getSaveTo() . '/' . $filename
        ];

    }

    /**
     * @param string $filename
     *
     * @return string|null
     */
    public function getExtensionFromFilename(string $filename): ?string
    {

        $position = strripos($filename, '.');

        if (!$position) {
            return null;
        }

        return substr($filename, $position);

    }

    /**
     * @param string $filename
     *
     * @return string|null
     */
    public function getFilenameWithoutExtension(string $filename): ?string
    {

        $position = strripos($filename, '.');

        if (!$position) {
            return null;
        }

        return substr($filename, 0, $position);

    }

}