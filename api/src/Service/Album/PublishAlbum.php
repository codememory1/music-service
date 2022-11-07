<?php

namespace App\Service\Album;

use App\Entity\Album;
use App\Entity\Multimedia;
use App\Enum\AlbumStatusEnum;
use App\Event\AlbumStatusChangeEvent;
use App\Exception\Http\AlbumException;
use App\Service\FlusherService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PublishAlbum
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function publish(Album $album): Album
    {
        if ($album->isPublished()) {
            throw AlbumException::badPublicationToAlreadyPublication();
        }

        $publishedMultimediaToAlbum = $album
            ->getMultimedia()
            ->filter(static fn(Multimedia $multimedia) => $multimedia->isPublished());

        if (0 === $publishedMultimediaToAlbum->count()) {
            throw AlbumException::badPublicationWithoutPublishedMultimedia();
        }

        $album->setPublishStatus();

        $this->flusher->save();

        $this->eventDispatcher->dispatch(new AlbumStatusChangeEvent($album, AlbumStatusEnum::PUBLISHED));

        return $album;
    }
}