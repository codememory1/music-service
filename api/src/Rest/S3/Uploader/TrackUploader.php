<?php

namespace App\Rest\S3\Uploader;

/**
 * Class TrackUploader.
 *
 * @package App\Rest\S3\Uploader
 *
 * @author  Codememory
 */
class TrackUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'track';
    }
}