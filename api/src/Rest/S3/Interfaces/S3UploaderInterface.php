<?php

namespace App\Rest\S3\Interfaces;

use App\Rest\S3\Uploader\UploadedFile as S3UploadedFile;
use Aws\Result;

/**
 * Interface S3UploaderInterface.
 *
 * @package  App\Rest\S3\Interfaces
 *
 * @author   Codememory
 */
interface S3UploaderInterface
{
    public function getBucketName(): string;

    public function upload(string $pathInSystem, string $mimeType, string $uuid, array $args = []): Result;

    public function save(?string $oldFilePathInStorage, string $newFilePathInSystem, string $mimeType, string $uuid, array $args = []): ?Result;

    public function delete(string $pathInStorage, array $argc = []): Result;

    public function getUploadedFile(): S3UploadedFile;
}