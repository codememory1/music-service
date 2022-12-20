<?php

namespace App\Rest\S3\Uploader;

final class SubtitlesUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'subtitles';
    }
}