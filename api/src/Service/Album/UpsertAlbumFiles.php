<?php

namespace App\Service\Album;

use App\Entity\Album;
use App\Rest\S3\Uploader\ImageUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpsertAlbumFiles
{
    public function __construct(
        private readonly ImageUploader $imageUploader
    ) {
    }

    public function uploadImage(UploadedFile $file, Album $album): string
    {
        $this->imageUploader->save($album->getImage(), $file, 'image', $album);

        return $this->imageUploader->getUploadedFile()->first();
    }
}