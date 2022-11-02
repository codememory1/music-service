<?php

namespace App\Service\Playlist;

use App\Dto\Transfer\PlaylistDto;
use App\Entity\Playlist;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\FileUploader\Uploader;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SavePlaylistService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly Uploader $fileUploader,
        private readonly SetMultimediaToPlaylistService $setMultimediaToPlaylist,
        private readonly ImageUploader $imageUploader,
    ) {
    }

    public function make(PlaylistDto $playlistDto, Playlist $playlist): void
    {
        $this->setMultimediaToPlaylist->set($playlistDto->multimedia, $playlist);

        $playlist->setImage($this->uploadImage($playlistDto->image, $playlist));

        $this->flusherService->save($playlist);
    }

    private function uploadImage(UploadedFile $image, Playlist $playlist): ?string
    {
        return $this->fileUploader->simpleUpload($this->imageUploader, $playlist->getImage(), $image, 'image', $playlist);
    }
}