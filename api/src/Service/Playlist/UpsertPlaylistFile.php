<?php

namespace App\Service\Playlist;

use App\Entity\Playlist;
use App\Rest\S3\Uploader\ImageUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpsertPlaylistFile
{
    public function __construct(
        private readonly ImageUploader $imageUploader
    ) {
    }

    public function uploadImage(UploadedFile $file, Playlist $playlist): string
    {
        $this->imageUploader->save($playlist->getImage(), $file, 'image', $playlist);

        return $this->imageUploader->getUploadedFile()->first();
    }
}