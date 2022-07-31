<?php

namespace App\Service\Playlist;

use App\Dto\Transfer\PlaylistDto;
use App\Entity\Playlist;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SavePlaylistService.
 *
 * @package App\Service\Playlist
 *
 * @author  Codememory
 */
class SavePlaylistService extends AbstractService
{
    #[Required]
    public ?SetMultimediaToPlaylistService $setMultimediaToPlaylistService = null;

    #[Required]
    public ?ImageUploader $imageUploader = null;

    public function make(PlaylistDto $playlistDto, Playlist $playlist): void
    {
        $this->setMultimediaToPlaylistService->set($playlistDto->multimedia, $playlist);

        $playlist->setImage($this->uploadImage($playlistDto->image, $playlist));

        $this->flusherService->save($playlist);
    }

    private function uploadImage(UploadedFile $image, Playlist $playlist): ?string
    {
        return $this->simpleFileUpload($this->imageUploader, $playlist->getImage(), $image, $playlist);
    }
}