<?php

namespace App\UseCase\Album;

use App\Entity\Album;
use App\Enum\AlbumStatusEnum;
use App\Event\AlbumStatusChangeEvent;
use App\Exception\Http\AlbumException;
use App\Infrastructure\Doctrine\Flusher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class PublishAlbum
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function process(Album $album): Album
    {
        if ($album->isPublished()) {
            throw AlbumException::badPublicationToAlreadyPublication();
        }

        if (0 === $album->getPublishedMultimedia()->count()) {
            throw AlbumException::badPublicationWithoutPublishedMultimedia();
        }

        $album->setPublishStatus();

        $this->flusher->save();

        $this->eventDispatcher->dispatch(new AlbumStatusChangeEvent($album, AlbumStatusEnum::PUBLISHED));

        return $album;
    }
}