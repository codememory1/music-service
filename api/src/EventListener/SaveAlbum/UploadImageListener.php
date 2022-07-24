<?php

namespace App\EventListener\SaveAlbum;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Event\SaveAlbumEvent;
use App\Rest\S3\Uploader\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UploadImageListener.
 *
 * @package App\EventListener\SaveAlbum
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

    public function onSaveAlbum(SaveAlbumEvent $event): void
    {
        $this->imageUploader->setEntity($event->album);
        $this->imageUploader->setUser($event->album->getUser());

        $event->album->setImage($this->uploadImage($event->albumDTO, $event->album));

        $this->em->flush();
    }

    private function uploadImage(AlbumDTO $albumDTO, Album $album): string
    {
        $this->imageUploader->save(
            $album->getImage(),
            $albumDTO->image->getRealPath(),
            $albumDTO->image->getMimeType()
        );

        return $this->imageUploader->getUploadedFile()->last();
    }
}