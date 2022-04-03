<?php

namespace App\Service;

use App\Rest\Http\Request;
use function call_user_func;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class FileUploaderService.
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
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameters;

    /**
     * @var null|string
     */
    private ?string $saveTo = null;

    /**
     * @var array
     */
    private array $uploadedFile = [];

    /**
     * @var null|UploadedFile
     */
    private ?UploadedFile $file = null;

    /**
     * @param Request               $request
     * @param ParameterBagInterface $parameters
     */
    public function __construct(Request $request, ParameterBagInterface $parameters)
    {
        $this->fileBag = $request->request->files;
        $this->parameters = $parameters;
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
    public function initRequestFile(string $requestFileName): self
    {
        $this->file = $this->fileBag->get($requestFileName);

        return $this;
    }

    /**
     * @return null|UploadedFile
     */
    public function getInitializedRequestFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param null|callable $handlerFilename
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     *
     * @return $this
     */
    public function upload(?callable $handlerFilename = null): self
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
     * @return null|string
     */
    public function getExtensionFromFilename(string $filename): ?string
    {
        $position = mb_strripos($filename, '.');

        if (!$position) {
            return null;
        }

        return mb_substr($filename, $position);
    }

    /**
     * @param string $filename
     *
     * @return null|string
     */
    public function getFilenameWithoutExtension(string $filename): ?string
    {
        $position = mb_strripos($filename, '.');

        if (!$position) {
            return null;
        }

        return mb_substr($filename, 0, $position);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     *
     * @return string
     */
    public function getAbsoluteSaveTo(): string
    {
        $kernelProjectDir = rtrim($this->parameters->get('kernel.project_dir'), '/');

        return sprintf('%s/%s', $kernelProjectDir, rtrim($this->saveTo, '/'));
    }

    /**
     * @return null|string
     */
    public function getSaveTo(): ?string
    {
        return $this->saveTo;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setSaveTo(string $path): self
    {
        $this->saveTo = $path;

        return $this;
    }

    /**
     * @param string $filename
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     *
     * @return array
     */
    #[ArrayShape([
        'filename' => 'string',
        'filename_without_extension' => 'false|string',
        'filename_with_absolute_path' => 'string',
        'filename_with_path' => 'string'
    ])]
    private function schemaUploadedFile(string $filename): array
    {
        return [
            'filename' => $filename,
            'filename_without_extension' => $this->getFilenameWithoutExtension($filename),
            'filename_with_absolute_path' => $this->getAbsoluteSaveTo() . '/' . $filename,
            'filename_with_path' => $this->getSaveTo() . '/' . $filename
        ];
    }
}