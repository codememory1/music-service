<?php

namespace App\Service\Playlist;

use App\Dto\Transfer\PlaylistDto;
use App\Entity\Playlist;
use App\Infrastructure\Doctrine\Flusher;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\FileUploader\Uploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpsertPlaylist
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Uploader $fileUploader,
        private readonly SetMultimediaToPlaylist $setMultimediaToPlaylist,
        private readonly ImageUploader $imageUploader,
    ) {
    }

    public function save(PlaylistDto $dto, Playlist $playlist): void
    {
        $this->setMultimediaToPlaylist->set($dto->multimedia, $playlist);

        $playlist->setImage($this->uploadImage($dto->image, $playlist));

        $this->flusher->save($playlist);
    }

    private function uploadImage(UploadedFile $image, Playlist $playlist): ?string
    {
        return $this->fileUploader->simpleUpload($this->imageUploader, $playlist->getImage(), $image, 'image', $playlist);
    }
}