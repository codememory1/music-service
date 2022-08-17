<?php

namespace App\Service\Album;

use App\Entity\Album;
use App\Entity\Multimedia;
use App\Enum\AlbumStatusEnum;
use App\Enum\EventEnum;
use App\Event\AlbumStatusChangeEvent;
use App\Exception\Http\AlbumException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class PublishAlbumService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

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

        $this->flusherService->save();

        $this->eventDispatcher->dispatch(
            new AlbumStatusChangeEvent($album, AlbumStatusEnum::PUBLISHED),
            EventEnum::ALBUM_STATUS_CHANGE->value
        );

        return $album;
    }

    public function request(Album $album): JsonResponse
    {
        $this->publish($album);

        return $this->responseCollection->successUpdate('album@successPublication');
    }
}