<?php

namespace App\UseCase\Multimedia;

use App\Dto\Transfer\MultimediaDto;
use App\Entity\Multimedia;
use App\Enum\AlbumTypeEnum;
use App\Enum\MultimediaTypeEnum;
use App\Enum\PlatformSettingEnum;
use App\Event\SaveMultimediaEvent;
use App\Exception\Http\AlbumException;
use App\Exception\Http\InvalidException;
use App\Exception\Http\MultimediaException;
use App\Infrastructure\Doctrine\Flusher;
use App\Message\MultimediaMetadataMessage;
use App\Service\Multimedia\MultimediaStream;
use App\Service\Multimedia\MultimediaValidator;
use App\Service\Multimedia\UpsertMultimediaFile;
use App\Service\PlatformSetting;
use FFMpeg\FFProbe\DataMapping\Stream;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpsertMultimedia
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly MultimediaValidator $multimediaValidator,
        private readonly MultimediaStream $multimediaStream,
        private readonly PlatformSetting $platformSetting,
        private readonly UpsertMultimediaFile $upsertMediaFile,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly MessageBusInterface $bus,
    ) {
    }

    public function process(MultimediaDto $dto, Multimedia $multimedia): Multimedia
    {
        $this->validateAlbumType($multimedia);

        $stream = $this->multimediaStream->createStreamByMultimediaType($dto->multimedia, $dto->type);

        if (null === $stream) {
            throw InvalidException::invalidMultimedia();
        }

        if (MultimediaTypeEnum::TRACK->name === $multimedia->getType()) {
            $this->validateTrack($dto, $stream);
        }

        if (MultimediaTypeEnum::CLIP->name === $multimedia->getType()) {
            $this->validateClip($dto, $stream);
        }

        if (null !== $dto->subtitles && false === $this->multimediaValidator->isValidatedSubtitles($dto->subtitles)) {
            throw InvalidException::invalidSubtitles();
        }

        $this->uploadFiles($dto, $multimedia);

        $this->flusher->save($multimedia);

        $this->bus->dispatch(new MultimediaMetadataMessage($multimedia->getId()));

        $this->eventDispatcher->dispatch(new SaveMultimediaEvent($multimedia));

        return $multimedia;
    }

    private function validateTrack(MultimediaDto $dto, Stream $stream): void
    {
        if (false === $this->multimediaValidator->isValidatedTrackMimeType($dto->multimedia)) {
            throw MultimediaException::badTrackMimeType();
        }

        $maxAllowedDuration = $this->platformSetting->get(PlatformSettingEnum::MULTIMEDIA_DURATION_TRACK_KEY);

        if (false === $this->multimediaValidator->isValidatedTrackDuration($stream, $maxAllowedDuration)) {
            throw MultimediaException::badDuration(['duration' => $maxAllowedDuration]);
        }
    }

    private function validateClip(MultimediaDto $dto, Stream $stream): void
    {
        if (false === $this->multimediaValidator->isValidatedClipMimeType($dto->multimedia)) {
            throw MultimediaException::badClipMimeType();
        }

        $maxAllowedDuration = $this->platformSetting->get(PlatformSettingEnum::MULTIMEDIA_DURATION_CLIP_KEY);

        if (false === $this->multimediaValidator->isValidatedClipDuration($stream, $maxAllowedDuration)) {
            throw MultimediaException::badDuration(['duration' => $maxAllowedDuration]);
        }
    }

    private function validateAlbumType(Multimedia $multimedia): void
    {
        $album = $multimedia->getAlbum();

        if (AlbumTypeEnum::SINGLE->name === $album->getType()->getKey() && 0 < $album->getMultimedia()->count()) {
            throw AlbumException::badAddMultimediaToSingleAlbum();
        }
    }

    private function uploadFiles(MultimediaDto $dto, Multimedia $multimedia): void
    {
        $multimedia->setImage($this->upsertMediaFile->uploadImage($dto->image, $multimedia));
        $multimedia->setMultimedia($this->upsertMediaFile->uploadMedia($dto->multimedia, $multimedia));

        if (null !== $dto->subtitles) {
            $multimedia->setSubtitles($this->upsertMediaFile->uploadSubtitles($dto->subtitles, $multimedia));
        }
    }
}