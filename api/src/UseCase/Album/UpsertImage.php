<?php

namespace App\UseCase\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Rest\S3\Uploader\ImageUploader;

final class UpsertImage
{
    public function __construct(
        private readonly ImageUploader $imageUploader
    ) {
    }

    public function process(AlbumDto $dto, Album $album): string
    {
        $this->imageUploader->save($album->getImage(), $dto->image, 'image', $album);

        return $this->imageUploader->getUploadedFile()->first();
    }
}