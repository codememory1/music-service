<?php

namespace App\Rest\S3\Interfaces;

use App\Entity\Interfaces\EntityS3SettingInterface;
use App\Rest\S3\Uploader\UploadedFile as S3UploadedFile;
use Aws\Result;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface S3UploaderInterface
{
    public function getBucketName(): string;

    public function upload(
        UploadedFile $file,
        string $propertyName,
        EntityS3SettingInterface $entityS3Setting,
        array $args = []
    ): Result;

    public function save(
        ?string $oldFilePathInStorage,
        UploadedFile $file,
        string $propertyName,
        EntityS3SettingInterface $entityS3Setting,
        array $args = []
    ): ?Result;

    public function delete(string $pathInStorage, array $argc = []): Result;

    public function getUploadedFile(): S3UploadedFile;
}