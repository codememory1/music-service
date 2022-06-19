<?php

namespace App\EventListener\AddMultimedia;

use App\Entity\Multimedia;
use App\Enum\AlbumTypeEnum;
use App\Event\AddMultimediaEvent;
use App\Rest\Http\Exceptions\AlbumException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AlbumTypeCheckListener.
 *
 * @package App\EventListener\AddMultimedia
 *
 * @author  Codememory
 */
class AlbumTypeCheckListener
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    /**
     * @param AddMultimediaEvent $event
     *
     * @return void
     */
    public function onBeforeAddMultimedia(AddMultimediaEvent $event): void
    {
        $multimediaRepository = $this->em->getRepository(Multimedia::class);
        $album = $event->multimediaDTO->album;
        $albumType = $album->getType();

        if (AlbumTypeEnum::SINGLE->name === $albumType->getKey() && null !== $multimediaRepository->getByAlbum($album)) {
            throw AlbumException::badAddMultimediaToSingleAlbum();
        }
    }
}