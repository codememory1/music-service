<?php

namespace App\EventListener\SaveMultimedia\Before;

use App\Entity\Multimedia;
use App\Enum\AlbumTypeEnum;
use App\Event\SaveMultimediaEvent;
use App\Repository\MultimediaRepository;
use App\Rest\Http\Exceptions\AlbumException;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AlbumTypeCheckListener.
 *
 * @package App\EventListener\SaveMultimedia\Before
 *
 * @author  Codememory
 */
class AlbumTypeCheckListener
{
    #[Required]
    public ?MultimediaRepository $multimediaRepository = null;

    public function onBeforeSaveMultimedia(SaveMultimediaEvent $event): void
    {
        $albumType = $event->multimediaDTO->album->getType();

        if (AlbumTypeEnum::SINGLE->name === $albumType->getKey() && null !== $this->getMultimedia($event)) {
            throw AlbumException::badAddMultimediaToSingleAlbum();
        }
    }

    private function getMultimedia(SaveMultimediaEvent $event): ?Multimedia
    {
        if (null !== $event->multimedia->getId()) {
            return $event->multimedia;
        }

        return $this->multimediaRepository->getByAlbum($event->multimediaDTO->album);
    }
}