<?php

namespace App\Service\Album;

use App\Entity\Album;
use App\Entity\Multimedia;
use App\Enum\AlbumStatusEnum;
use App\Enum\EventEnum;
use App\Enum\MultimediaStatusEnum;
use App\Event\AlbumStatusChangeEvent;
use App\Rest\Http\Exceptions\AlbumException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class PublishAlbumService.
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class PublishAlbumService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function make(Album $album): JsonResponse
    {
        if ($album->getStatus() === AlbumStatusEnum::PUBLISHED->name) {
            throw AlbumException::badPublicationToAlreadyPublication();
        }

        $publishedMultimediaToAlbum = $album->getMultimedia()->filter(static fn(Multimedia $multimedia) => $multimedia->getStatus() === MultimediaStatusEnum::PUBLISHED->name);

        if (0 === $publishedMultimediaToAlbum->count()) {
            throw AlbumException::badPublicationWithoutPublishedMultimedia();
        }

        $album->setPublishStatus();

        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new AlbumStatusChangeEvent($album, AlbumStatusEnum::PUBLISHED),
            EventEnum::ALBUM_STATUS_CHANGE->value
        );

        return $this->responseCollection->successUpdate('album@successPublication');
    }
}