<?php

namespace App\Rest\S3\Uploader;

/**
 * Class SubtitlesUploader.
 *
 * @package App\Rest\S3\Uploader
 *
 * @author  Codememory
 */
class SubtitlesUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'subtitles';
    }
}