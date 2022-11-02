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
use App\Message\MultimediaMetadataMessage;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Service\FileUploader\Uploader;
use App\Service\FlusherService;
use Captioning\Format\SubripFile;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\MessageBusInterface;

class SaveMultimediaService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly EntityManagerInterface $em,
        private readonly Uploader $fileUploader,
        private readonly MultimediaMetadataValidationService $multimediaMetadataValidation,
        private readonly ImageUploader $imageUploader,
        private readonly TrackUploader $trackUploader,
        private readonly ClipUploader $clipUploader,
        private readonly SubtitlesUploader $subtitlesUploader,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly MessageBusInterface $bus,
    ) {}

    public function make(MultimediaDto $multimediaDto, Multimedia $multimedia): void
    {
        $this->fileValidationWrapper($multimediaDto, $multimedia);

        $multimedia->setImage($this->uploadImage($multimediaDto->image, $multimedia));
        $multimedia->setMultimedia($this->uploadMultimedia($multimediaDto->multimedia, $multimedia));
        $multimedia->setSubtitles($this->uploadSubtitles($multimediaDto->subtitles, $multimedia));

        $this->flusherService->save($multimedia);

        $this->bus->dispatch(new MultimediaMetadataMessage($multimedia->getId()));
        $this->eventDispatcher->dispatch(new SaveMultimediaEvent($multimedia));
    }

    private function fileValidationWrapper(MultimediaDto $multimediaDto, Multimedia $multimedia): void
    {
        $this->checkAlbumType($multimedia);
        $this->checkMultimediaMimeType($multimediaDto, $multimedia);
        $this->checkSubtitles($multimediaDto);

        $stream = $this->multimediaMetadataValidation->initMultimedia($multimediaDto->multimedia, $multimedia);
        
        $this->multimediaMetadataValidation->validateDuration($multimedia, $stream);
    }

    private function getMultimedia(Multimedia $multimedia): ?Multimedia
    {
        $multimediaRepository = $this->em->getRepository(Multimedia::class);

        if (null !== $multimedia->getId()) {
            return $multimedia;
        }

        return $multimediaRepository->getByAlbum($multimedia->getAlbum());
    }

    private function checkAlbumType(Multimedia $multimedia): void
    {
        $albumType = $multimedia->getAlbum()->getType();

        if (AlbumTypeEnum::SINGLE->name === $albumType->getKey() && null !== $this->getMultimedia($multimedia)) {
            throw AlbumException::badAddMultimediaToSingleAlbum();
        }
    }

    private function checkMultimediaMimeType(MultimediaDto $multimediaDto, Multimedia $multimedia): void
    {
        $multimediaMimeType = $multimediaDto->multimedia->getMimeType();

        if ($multimedia->isTrack()) {
            if (false === in_array($multimediaMimeType, MultimediaMimeTypeEnum::trackMimeTypes(), true)) {
                throw MultimediaException::badTrackMimeType();
            }
        } elseif ($multimedia->isClip()) {
            if (false === in_array($multimediaMimeType, MultimediaMimeTypeEnum::clipMimeTypes(), true)) {
                throw MultimediaException::badClipMimeType();
            }
        }
    }

    private function checkSubtitles(MultimediaDto $multimediaDto): void
    {
        if (null !== $multimediaDto->subtitles) {
            try {
                new SubripFile($multimediaDto->subtitles->getRealPath());
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

    private function uploadSubtitles(?UploadedFile $subtitles, Multimedia $multimedia): ?string
    {
        if (null === $subtitles) {
            return null;
        }

        return $this->fileUploader->simpleUpload(
            $this->subtitlesUploader,
            $multimedia->getSubtitles(),
            $subtitles,
            'subtitles',
            $multimedia
        );
    }
}