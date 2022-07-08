<?php

namespace App\EventListener\SavePlaylist;

use App\Event\SavePlaylistEvent;
use App\Rest\S3\Uploader\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UploadImageListener.
 *
 * @package App\EventListener\SavePlaylist
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

    public function onSavePlaylist(SavePlaylistEvent $event): void
    {
        $image = $event->playlistDTO->image;

        if (false === empty($image)) {
            $this->imageUploader->setUser($event->playlist->getMediaLibrary()->getUser());
            $this->imageUploader->setEntity($event->playlist);
            $this->imageUploader->upload($image->getRealPath(), $image->getMimeType());

            $event->playlist->setImage($this->imageUploader->getUploadedFile()->first());

            $this->em->flush();
        }
    }
}