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
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var ImageUploader
     */
    private ImageUploader $imageUploader;

    /**
     * @param EntityManagerInterface $manager
     * @param ImageUploader          $imageUploader
     */
    public function __construct(EntityManagerInterface $manager, ImageUploader $imageUploader)
    {
        $this->em = $manager;
        $this->imageUploader = $imageUploader;
    }

    /**
     * @param SaveAlbumEvent $event
     *
     * @return void
     */
    public function onSaveAlbum(SaveAlbumEvent $event): void
    {
        $this->imageUploader->setEntity($event->album);
        $this->imageUploader->setUser($event->album->getUser());

        $event->album->setImage($this->uploadImage($event->albumDTO, $event->album));

        $this->em->flush();
    }

    /**
     * @param AlbumDTO $albumDTO
     * @param Album    $album
     *
     * @return string
     */
    private function uploadImage(AlbumDTO $albumDTO, Album $album): string
    {
        $this->imageUploader->save($album->getImage(), $albumDTO->image->getRealPath(), $albumDTO->image->getMimeType());

        return $this->imageUploader->getUploadedFile()->last();
    }
}