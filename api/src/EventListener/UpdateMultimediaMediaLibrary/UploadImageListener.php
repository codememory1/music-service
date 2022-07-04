<?php

namespace App\EventListener\UpdateMultimediaMediaLibrary;

use App\Event\UpdateMultimediaMediaLibraryEvent;
use App\Rest\S3\Uploader\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UploadImageListener.
 *
 * @package App\EventListener\UpdateMultimediaMediaLibrary
 *
 * @author  Codememory
 */
class UploadImageListener
{
    private EntityManagerInterface $em;
    private ImageUploader $imageUploader;

    public function __construct(EntityManagerInterface $manager, ImageUploader $imageUploader)
    {
        $this->em = $manager;
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

        $this->em->flush();
    }
}