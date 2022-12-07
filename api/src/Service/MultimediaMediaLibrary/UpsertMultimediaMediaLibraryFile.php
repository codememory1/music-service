<?php

namespace App\Service\MultimediaMediaLibrary;

use App\Entity\MultimediaMediaLibrary;
use App\Rest\S3\Uploader\ImageUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpsertMultimediaMediaLibraryFile
{
    public function __construct(
        private readonly ImageUploader $imageUploader
    ) {
    }

    public function uploadImage(UploadedFile $file, MultimediaMediaLibrary $multimediaMediaLibrary): string
    {
        $this->imageUploader->save($multimediaMediaLibrary->getImage(), $file, 'image', $multimediaMediaLibrary);

        return $this->imageUploader->getUploadedFile()->first();
    }
}