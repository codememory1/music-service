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
    /**
     * @inheritDoc
     */
    public function getBucketName(): string
    {
        return 'image';
    }
}