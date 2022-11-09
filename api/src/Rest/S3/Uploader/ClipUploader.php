<?php

namespace App\Rest\S3\Uploader;

final class ClipUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'clip';
    }
}