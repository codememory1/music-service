<?php

namespace App\Rest\S3\Uploader;

class ClipUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'clip';
    }
}