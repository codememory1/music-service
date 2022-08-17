<?php

namespace App\Rest\S3\Uploader;

class TrackUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'track';
    }
}