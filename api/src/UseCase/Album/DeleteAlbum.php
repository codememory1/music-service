<?php

namespace App\UseCase\Album;

use App\Entity\Album;
use App\Infrastructure\Doctrine\Flusher;
use App\Rest\S3\Uploader\ImageUploader;
use App\UseCase\Multimedia\DeleteMultimediaFiles;

final class DeleteAlbum
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly ImageUploader $imageUploader,
        private readonly DeleteMultimediaFiles $deleteMultimediaFiles
    ) {
    }

    public function process(Album $album): Album
    {
        $this->imageUploader->delete($album->getImage());

        $this->flusher->remove($album);

        foreach ($album->getMultimedia() as $multimedia) {
            $this->deleteMultimediaFiles->process($multimedia);
        }

        return $album;
    }
}