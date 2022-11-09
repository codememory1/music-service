<?php

namespace App\Service\Multimedia;

use App\Dto\Transfer\MultimediaDto;
use App\Entity\Multimedia;
use App\Enum\AlbumTypeEnum;
use App\Enum\MultimediaMimeTypeEnum;
use App\Event\SaveMultimediaEvent;
use App\Exception\Http\AlbumException;
use App\Exception\Http\InvalidException;
use App\Exception\Http\MultimediaException;
use App\Infrastructure\Doctrine\Flusher;
use App\Message\MultimediaMetadataMessage;
use App\Repository\MultimediaRepository;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Service\FileUploader\Uploader;
use Captioning\Format\SubripFile;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpsertMultimedia
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly MultimediaRepository $multimediaRepository,
        private readonly Uploader $fileUploader,
        private readonly MultimediaMetadataValidation $multimediaMetadataValidation,
        private readonly ImageUploader $imageUploader,
        private readonly TrackUploader $trackUploader,
        private readonly ClipUploader $clipUploader,
        private readonly SubtitlesUploader $subtitlesUploader,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly MessageBusInterface $bus,
    ) {
    }

    public function save(MultimediaDto $dto, Multimedia $multimedia): void
    {
        $this->fileValidationWrapper($dto, $multimedia);

        $multimedia->setImage($this->uploadImage($dto->image, $multimedia));
        $multimedia->setMultimedia($this->uploadMultimedia($dto->multimedia, $multimedia));
        $multimedia->setSubtitles($this->uploadSubtitles($dto->subtitles, $multimedia));

        $this->flusher->save($multimedia);

        $this->bus->dispatch(new MultimediaMetadataMessage($multimedia->getId()));

        $this->eventDispatcher->dispatch(new SaveMultimediaEvent($multimedia));
    }

    private function fileValidationWrapper(MultimediaDto $dto, Multimedia $multimedia): void
    {
        $this->checkAlbumType($multimedia);
        $this->checkMultimediaMimeType($dto, $multimedia);
        $this->checkSubtitles($dto);

        $this->multimediaMetadataValidation->validateDuration(
            $multimedia,
            $this->multimediaMetadataValidation->initMultimedia($dto->multimedia, $multimedia)
        );
    }

    private function getMultimedia(Multimedia $multimedia): ?Multimedia
    {
        if (null !== $multimedia->getId()) {
            return $multimedia;
        }

        return $this->multimediaRepository->getByAlbum($multimedia->getAlbum());
    }

    private function checkAlbumType(Multimedia $multimedia): void
    {
        $type = $multimedia->getAlbum()->getType();

        if (AlbumTypeEnum::SINGLE->name === $type->getKey() && null !== $this->getMultimedia($multimedia)) {
            throw AlbumException::badAddMultimediaToSingleAlbum();
        }
    }

    private function checkMultimediaMimeType(MultimediaDto $dto, Multimedia $multimedia): void
    {
        $multimediaMimeType = $dto->multimedia->getMimeType();

        if ($multimedia->isTrack()) {
            if (false === in_array($multimediaMimeType, MultimediaMimeTypeEnum::trackMimeTypes(), true)) {
                throw MultimediaException::badTrackMimeType();
            }
        } else {
            if ($multimedia->isClip()) {
                if (false === in_array($multimediaMimeType, MultimediaMimeTypeEnum::clipMimeTypes(), true)) {
                    throw MultimediaException::badClipMimeType();
                }
            }
        }
    }

    private function checkSubtitles(MultimediaDto $dto): void
    {
        if (null !== $dto->subtitles) {
            try {
                new SubripFile($dto->subtitles->getRealPath());
            } catch (Exception) {
                throw InvalidException::invalidSubtitles();
            }
        }
    }

    private function uploadImage(UploadedFile $image, Multimedia $multimedia): ?string
    {
        return $this->fileUploader->simpleUpload($this->imageUploader, $multimedia->getImage(), $image, 'image', $multimedia);
    }

    private function uploadMultimedia(UploadedFile $multimediaFile, Multimedia $multimedia): ?string
    {
        if ($multimedia->isTrack()) {
            return $this->fileUploader->simpleUpload(
                $this->trackUploader,
                $multimedia->getMultimedia(),
                $multimediaFile,
                'multimedia',
                $multimedia
            );
        }

        if ($multimedia->isClip()) {
            return $this->fileUploader->simpleUpload(
                $this->clipUploader,
                $multimedia->getMultimedia(),
                $multimediaFile,
                'multimedia',
                $multimedia
            );
        }

        return null;
    }

    private function uploadSubtitles(?UploadedFile $subtitlesFile, Multimedia $multimedia): ?string
    {
        if (null === $subtitlesFile) {
            return null;
        }

        return $this->fileUploader->simpleUpload(
            $this->subtitlesUploader,
            $multimedia->getSubtitles(),
            $subtitlesFile,
            'subtitles',
            $multimedia
        );
    }
}