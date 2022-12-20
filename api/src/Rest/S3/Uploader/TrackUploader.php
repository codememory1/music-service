<?php

namespace App\Rest\S3\Uploader;

final class TrackUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'track';
    }
}