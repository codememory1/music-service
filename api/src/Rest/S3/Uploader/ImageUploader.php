<?php

namespace App\Rest\S3\Uploader;

class ImageUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'image';
    }
}