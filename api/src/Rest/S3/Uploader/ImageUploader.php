<?php

namespace App\Rest\S3\Uploader;

/**
 * Class ImageUploader.
 *
 * @package App\Rest\S3\Uploader
 *
 * @author  Codememory
 */
class ImageUploader extends AbstractUploader
{
    public function getBucketName(): string
    {
        return 'image';
    }
}