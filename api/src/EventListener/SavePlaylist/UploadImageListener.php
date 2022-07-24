<?php

namespace App\EventListener\SavePlaylist;

use App\Event\SavePlaylistEvent;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\FlusherService;

/**
 * Class UploadImageListener.
 *
 * @package App\EventListener\SavePlaylist
 *
 * @author  Codememory
 */
class UploadImageListener
{
    private FlusherService $flusherService;
    private ImageUploader $imageUploader;

    public function __construct(FlusherService $flusherService, ImageUploader $imageUploader)
    {
        $this->flusherService = $flusherService;
        $this->imageUploader = $imageUploader;
    }

    public function onSavePlaylist(SavePlaylistEvent $event): void
    {
        $image = $event->playlistDTO->image;

        if (false === empty($image)) {
            $this->imageUploader->setUser($event->playlist->getMediaLibrary()->getUser());
            $this->imageUploader->setEntity($event->playlist);
            $this->imageUploader->upload($image->getRealPath(), $image->getMimeType());

            $event->playlist->setImage($this->imageUploader->getUploadedFile()->first());

            $this->flusherService->save();
        }
    }
}