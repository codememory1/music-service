<?php

namespace App\EventListener\UpdateMultimediaMediaLibrary;

use App\Event\UpdateMultimediaMediaLibraryEvent;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\FlusherService;

/**
 * Class UploadImageListener.
 *
 * @package App\EventListener\UpdateMultimediaMediaLibrary
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

    public function onUpdateMultimediaMediaLibrary(UpdateMultimediaMediaLibraryEvent $event): void
    {
        $image = $event->multimediaMediaLibraryDTO->image;

        if (null === $image) {
            $event->multimediaMediaLibrary->setImage(null);
        } else {
            $this->imageUploader->setEntity($event->multimediaMediaLibrary);
            $this->imageUploader->setUser($event->multimediaMediaLibrary->getMediaLibrary()->getUser());
            $this->imageUploader->upload($image->getRealPath(), $image->getMimeType());

            $event->multimediaMediaLibrary->setImage($this->imageUploader->getUploadedFile()->first());
        }

        $this->flusherService->save();
    }
}