<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MultimediaMediaLibrary;
use App\Enum\MultimediaMediaLibraryEventEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Exception\Http\EventException;
use App\Repository\MultimediaMediaLibraryRepository;
use App\Service\Event\MultimediaMediaLibrary\NextMultimediaAfterEndEvent;
use App\Service\Event\MultimediaMediaLibrary\RangeTimeEvent;

final class EventPayloadHandler
{
    public function __construct(
        private readonly MultimediaMediaLibraryRepository $multimediaMediaLibraryRepository
    ) {
    }

    public function handler(MultimediaMediaLibraryEventDto $dto, MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        $mediaLibrary = $multimediaMediaLibrary->getMediaLibrary();
        $schema = new ($dto->key->getNamespaceSchema())($dto->payload);

        match ($dto->key) {
            MultimediaMediaLibraryEventEnum::RANGE_TIME => $this->rangeTime($schema),
            MultimediaMediaLibraryEventEnum::NEXT_MULTIMEDIA_AFTER_END => $this->nextMultimediaAfterEnd($schema, $mediaLibrary),
        };
    }

    private function rangeTime(RangeTimeEvent $eventSchema): void
    {
        $from = $eventSchema->getFromTime();
        $to = $eventSchema->getToTime();

        if (null !== $from && null !== $to && $from > $to) {
            throw EventException::invalidRangeFromTime();
        }
    }

    private function nextMultimediaAfterEnd(NextMultimediaAfterEndEvent $eventSchema, MediaLibrary $mediaLibrary): void
    {
        $finedMultimediaMediaLibrary = $this->multimediaMediaLibraryRepository->find($eventSchema->getMultimediaId());

        if (null === $finedMultimediaMediaLibrary || false === $mediaLibrary->isMultimediaBelongsToMediaLibrary($finedMultimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }
    }
}