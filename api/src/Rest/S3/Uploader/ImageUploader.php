<?php

namespace App\Rest\S3\Uploader;

final class ImageUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'image';
    }
}