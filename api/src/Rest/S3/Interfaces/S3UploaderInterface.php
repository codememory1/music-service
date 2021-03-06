<?php

namespace App\Rest\S3\Interfaces;

use App\Rest\S3\Uploader\UploadedFile as S3UploadedFile;
use Aws\Result;
use Symfony\Component\HttpFoundation\File\UploadedFile as HttpUploadedFile;

/**
 * Interface S3UploaderInterface.
 *
 * @package  App\Rest\S3\Interfaces
 *
 * @author   Codememory
 */
interface S3UploaderInterface
{
    /**
     * @return string
     */
    public function getBucketName(): string;

    /**
     * @param HttpUploadedFile $uploadedFile
     * @param array            $dataForName
     * @param array            $args
     *
     * @return Result
     */
    public function upload(HttpUploadedFile $uploadedFile, array $dataForName, array $args = []): Result;

    /**
     * @param string $path
     * @param array  $argc
     *
     * @return Result
     */
    public function delete(string $path, array $argc = []): Result;

    /**
     * @return S3UploadedFile
     */
    public function getUploadedFile(): S3UploadedFile;
}