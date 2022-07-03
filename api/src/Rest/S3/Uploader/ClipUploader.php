<?php

namespace App\Rest\S3\Uploader;

/**
 * Class ClipUploader.
 *
 * @package App\Rest\S3\Uploader
 *
 * @author  codememory
 */
class ClipUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'clip';
    }
}