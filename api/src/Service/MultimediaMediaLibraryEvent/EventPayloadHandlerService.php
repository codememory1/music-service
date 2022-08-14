<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MultimediaMediaLibrary;
use App\Enum\MultimediaMediaLibraryEventEnum;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Rest\Http\Exceptions\EventException;
use App\Service\AbstractService;
use App\Service\Event\MultimediaMediaLibrary\NextMultimediaAfterEndEventService;
use App\Service\Event\MultimediaMediaLibrary\RangeTimeEventService;

class EventPayloadHandlerService extends AbstractService
{
    private ?MediaLibrary $mediaLibrary;

    public function handler(MultimediaMediaLibraryEventDto $multimediaMediaLibraryEventDto, MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        $this->mediaLibrary = $multimediaMediaLibrary->getMediaLibrary();

        $schema = new ($multimediaMediaLibraryEventDto->key->getNamespaceSchema())($multimediaMediaLibraryEventDto->payload);

        match ($multimediaMediaLibraryEventDto->key) {
            MultimediaMediaLibraryEventEnum::RANGE_TIME => $this->rangeTime($schema),
            MultimediaMediaLibraryEventEnum::NEXT_MULTIMEDIA_AFTER_END => $this->nextMultimediaAfterEnd($schema),
        };
    }

    private function rangeTime(RangeTimeEventService $eventSchema): void
    {
        $from = $eventSchema->getFromTime();
        $to = $eventSchema->getToTime();

        if (null !== $from && null !== $to && $from > $to) {
            throw EventException::invalidRangeFromTime();
        }
    }

    private function nextMultimediaAfterEnd(NextMultimediaAfterEndEventService $eventSchema): void
    {
        $multimediaMediaLibraryRepository = $this->em->getRepository(MultimediaMediaLibrary::class);
        $finedMultimediaMediaLibrary = $multimediaMediaLibraryRepository->find($eventSchema->getMultimediaId());

        if (null === $finedMultimediaMediaLibrary || false === $this->mediaLibrary->isMultimediaBelongsToMediaLibrary($finedMultimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }
    }
}