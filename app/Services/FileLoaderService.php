<?php

namespace App\Services;

use Codememory\HttpFoundation\FileUploader\Uploader;
use Codememory\HttpFoundation\Interfaces\FileUploadErrorInterface;
use Codememory\HttpFoundation\Interfaces\MakeUploadInterface;

/**
 * Class FileLoaderService
 *
 * @package App\Services
 *
 * @author  Danil
 */
class FileLoaderService extends AbstractApiService
{

    /**
     * @var Uploader
     */
    private Uploader $uploader;

    /**
     * @var array
     */
    private array $mimeTypes = [];

    /**
     * @var array
     */
    private array $extensions = [];

    /**
     * @var array
     */
    private array $numberFiles = [
        'min' => 1,
        'max' => 1
    ];

    /**
     * @var array
     */
    private array $overriddenErrors = [];

    /**
     * @var string
     */
    private string $saveIn = 'public/images/';

    /**
     * @var array
     */
    private array $uploadedFiles = [];

    /**
     * @param string $inputName
     *
     * @return $this
     */
    public function initUploader(string $inputName): FileLoaderService
    {

        $this->uploader = new Uploader($this->request, $inputName);

        return $this;

    }

    /**
     * @param array $mimeTypes
     *
     * @return $this
     */
    public function allowMimeTypes(array $mimeTypes): FileLoaderService
    {

        $this->mimeTypes = $mimeTypes;

        return $this;

    }

    /**
     * @param array $extensions
     *
     * @return $this
     */
    public function allowExtensions(array $extensions): FileLoaderService
    {

        $this->extensions = $extensions;

        return $this;

    }

    /**
     * @param int $min
     * @param int $max
     *
     * @return FileLoaderService
     */
    public function numberFiles(int $min, int $max): FileLoaderService
    {

        $this->numberFiles['min'] = $min;
        $this->numberFiles['max'] = $max;

        return $this;

    }

    /**
     * @param string $type
     * @param string $message
     *
     * @return $this
     */
    public function overrideError(string $type, string $message): FileLoaderService
    {

        $this->overriddenErrors[$type] = $message;

        return $this;

    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function saveIn(string $path): FileLoaderService
    {

        $this->saveIn = trim($path, '/') . '/';

        return $this;

    }

    /**
     * @param callable $nameHandler
     *
     * @return MakeUploadInterface
     */
    public function upload(callable $nameHandler): MakeUploadInterface
    {

        $uploader = $this->getUploader();

        return $uploader
            ->whereToSave($this->saveIn)
            ->mimeTypes($this->mimeTypes)
            ->extensions($this->extensions)
            ->numberUploads(
                $this->numberFiles['min'],
                $this->numberFiles['max']
            )
            ->customErrorHandler(function (FileUploadErrorInterface $fileUploadError) {
                foreach ($this->overriddenErrors as $type => $overriddenError) {
                    $fileUploadError->override($type, $overriddenError);
                }
            })
            ->changeUploadFilesData(function (array &$files) use ($nameHandler) {
                foreach ($files as &$file) {
                    $file['name'] = call_user_func($nameHandler, $file, $this->saveIn);
                }

                $this->uploadedFiles = $files;
            })
            ->make();

    }

    /**
     * @param bool $first
     *
     * @return array
     */
    public function getUploadedFiles(bool $first = false): array
    {

        $files = $this->uploadedFiles;

        if ($first) {
            return $files[array_key_first($files)];
        }

        return $files;

    }

    /**
     * @return string
     */
    public function getSaveIn(): string
    {

        return $this->saveIn;

    }

    /**
     * @return Uploader
     */
    public function getUploader(): Uploader
    {

        return $this->uploader;

    }

}