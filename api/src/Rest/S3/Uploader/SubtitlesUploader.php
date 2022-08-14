<?php

namespace App\Rest\S3\Uploader;

class SubtitlesUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'subtitles';
    }
}