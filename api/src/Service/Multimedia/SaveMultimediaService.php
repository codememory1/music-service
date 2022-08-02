<?php

namespace App\Service\Multimedia;

use App\Dto\Transfer\MultimediaDto;
use App\Entity\Multimedia;
use App\Enum\AlbumTypeEnum;
use App\Enum\EventEnum;
use App\Enum\MultimediaMimeTypeEnum;
use App\Event\SaveMultimediaEvent;
use App\Message\MultimediaMetadataMessage;
use App\Rest\Http\Exceptions\AlbumException;
use App\Rest\Http\Exceptions\InvalidException;
use App\Rest\Http\Exceptions\MultimediaException;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Service\AbstractService;
use Captioning\Format\SubripFile;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SaveMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class SaveMultimediaService extends AbstractService
{
    #[Required]
    public ?MultimediaMetadataValidationService $multimediaMetadataValidationService = null;

    #[Required]
    public ?ImageUploader $imageUploader = null;

    #[Required]
    public ?TrackUploader $trackUploader = null;

    #[Required]
    public ?ClipUploader $clipUploader = null;

    #[Required]
    public ?SubtitlesUploader $subtitlesUploader = null;

    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    #[Required]
    public ?MessageBusInterface $bus = null;

    public function make(MultimediaDto $multimediaDto, Multimedia $multimedia): void
    {
        $this->fileValidationWrapper($multimediaDto, $multimedia);

        $multimedia->setImage($this->uploadImage($multimediaDto->image, $multimedia));
        $multimedia->setMultimedia($this->uploadMultimedia($multimediaDto->multimedia, $multimedia));
        $multimedia->setSubtitles($this->uploadSubtitles($multimediaDto->subtitles, $multimedia));

        $this->flusherService->save($multimedia);

        $this->bus->dispatch(new MultimediaMetadataMessage($multimedia->getId()));
        $this->eventDispatcher->dispatch(
            new SaveMultimediaEvent($multimedia),
            EventEnum::AFTER_SAVE_MULTIMEDIA->value
        );
    }

    private function fileValidationWrapper(MultimediaDto $multimediaDto, Multimedia $multimedia): void
    {
        $this->checkAlbumType($multimedia);
        $this->checkMultimediaMimeType($multimediaDto, $multimedia);
        $this->checkSubtitles($multimediaDto);

        $this->multimediaMetadataValidationService->initMultimedia($multimediaDto->multimedia, $multimedia);
        $this->multimediaMetadataValidationService->validateDuration();
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
        return $this->simpleFileUpload($this->imageUploader, $multimedia->getImage(), $image, 'image', $multimedia);
    }

    private function uploadMultimedia(UploadedFile $multimediaFile, Multimedia $multimedia): ?string
    {
        if ($multimedia->isTrack()) {
            return $this->simpleFileUpload(
                $this->trackUploader,
                $multimedia->getMultimedia(),
                $multimediaFile,
                'multimedia',
                $multimedia
            );
        }

        if ($multimedia->isClip()) {
            return $this->simpleFileUpload(
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

        return $this->simpleFileUpload(
            $this->subtitlesUploader,
            $multimedia->getSubtitles(),
            $subtitles,
            'subtitles',
            $multimedia
        );
    }
}