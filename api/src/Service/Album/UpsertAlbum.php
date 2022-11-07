<?php

namespace App\Service\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\FileUploader\Uploader;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpsertAlbum
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly Uploader $fileUploader,
        private readonly ImageUploader $imageUploader,
    ) {
    }

    public function save(AlbumDto $albumDto, Album $album): Album
    {
        $album->setImage($this->uploadImage($albumDto->image, $album));

        $this->flusherService->save($album);

        return $album;
    }

    private function uploadImage(UploadedFile $image, Album $album): string
    {
        return $this->fileUploader->simpleUpload($this->imageUploader, $album->getImage(), $image, 'image', $album);
    }
}