<?php

namespace App\Service\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Infrastructure\Doctrine\Flusher;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\FileUploader\Uploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpsertAlbum
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Uploader $fileUploader,
        private readonly ImageUploader $imageUploader,
    ) {
    }

    public function save(AlbumDto $dto, Album $album): Album
    {
        $album->setImage($this->uploadImage($dto->image, $album));

        $this->flusher->save($album);

        return $album;
    }

    private function uploadImage(UploadedFile $image, Album $album): string
    {
        return $this->fileUploader->simpleUpload($this->imageUploader, $album->getImage(), $image, 'image', $album);
    }
}