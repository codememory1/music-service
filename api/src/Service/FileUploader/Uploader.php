<?php

namespace App\Service\FileUploader;

use App\Entity\Interfaces\EntityS3SettingInterface;
use App\Rest\S3\Interfaces\S3UploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    public function simpleUpload(
        S3UploaderInterface $s3Uploader,
        ?string $oldPath,
        UploadedFile $uploadedFile,
        string $propertyName,
        EntityS3SettingInterface $entityS3Setting
    ): ?string {
        $s3Uploader->save($oldPath, $uploadedFile, $propertyName, $entityS3Setting);

        return $s3Uploader->getUploadedFile()->first();
    }
}