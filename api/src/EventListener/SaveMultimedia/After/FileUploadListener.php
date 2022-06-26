<?php

namespace App\EventListener\SaveMultimedia\After;

use App\DTO\MultimediaDTO;
use App\Entity\Multimedia;
use App\Enum\MultimediaTypeEnum;
use App\Event\SaveMultimediaEvent;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FileUploadListener.
 *
 * @package App\EventListener\SaveMultimedia\After
 *
 * @author  Codememory
 */
class FileUploadListener
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var ImageUploader
     */
    private ImageUploader $imageUploader;

    /**
     * @var TrackUploader
     */
    private TrackUploader $trackUploader;

    /**
     * @var ClipUploader
     */
    private ClipUploader $clipUploader;

    /**
     * @var SubtitlesUploader
     */
    private SubtitlesUploader $subtitlesUploader;

    /**
     * @param EntityManagerInterface $manager
     * @param ImageUploader          $imageUploader
     * @param TrackUploader          $trackUploader
     * @param ClipUploader           $clipUploader
     * @param SubtitlesUploader      $subtitlesUploader
     */
    public function __construct(EntityManagerInterface $manager, ImageUploader $imageUploader, TrackUploader $trackUploader, ClipUploader $clipUploader, SubtitlesUploader $subtitlesUploader)
    {
        $this->em = $manager;
        $this->imageUploader = $imageUploader;
        $this->trackUploader = $trackUploader;
        $this->clipUploader = $clipUploader;
        $this->subtitlesUploader = $subtitlesUploader;
    }

    /**
     * @param SaveMultimediaEvent $event
     *
     * @return void
     */
    public function onAfterSaveMultimedia(SaveMultimediaEvent $event): void
    {
        $event->multimedia->setImage($this->uploadPreviewToStorage(
            $event->multimediaDTO,
            $event->multimedia
        ));
        $event->multimedia->setMultimedia($this->uploadMultimediaToStorage(
            $event->multimediaDTO,
            $event->multimedia
        ));
        $event->multimedia->setSubtitles($this->uploadSubtitlesToStorage(
            $event->multimediaDTO,
            $event->multimedia
        ));

        $this->em->flush();
    }

    /**
     * @param MultimediaDTO $multimediaDTO
     * @param Multimedia    $multimedia
     *
     * @return string
     */
    private function uploadPreviewToStorage(MultimediaDTO $multimediaDTO, Multimedia $multimedia): string
    {
        $this->imageUploader->upload($multimediaDTO->image, [$multimedia->getId()]);

        return $this->imageUploader->getUploadedFile()->last();
    }

    /**
     * @param MultimediaDTO $multimediaDTO
     * @param Multimedia    $multimedia
     *
     * @return null|string
     */
    private function uploadMultimediaToStorage(MultimediaDTO $multimediaDTO, Multimedia $multimedia): ?string
    {
        if (MultimediaTypeEnum::TRACK === $multimediaDTO->type) {
            $this->trackUploader->upload($multimediaDTO->multimedia, [$multimedia->getId()]);

            return $this->trackUploader->getUploadedFile()->last();
        } elseif (MultimediaTypeEnum::CLIP === $multimediaDTO->type) {
            $this->clipUploader->upload($multimediaDTO->multimedia, [$multimedia->getId()]);

            return $this->clipUploader->getUploadedFile()->last();
        }

        return null;
    }

    /**
     * @param MultimediaDTO $multimediaDTO
     * @param Multimedia    $multimedia
     *
     * @return null|string
     */
    private function uploadSubtitlesToStorage(MultimediaDTO $multimediaDTO, Multimedia $multimedia): ?string
    {
        if (null !== $multimediaDTO->subtitles) {
            $this->subtitlesUploader->upload($multimediaDTO->subtitles, [$multimedia->getId()]);

            return $this->subtitlesUploader->getUploadedFile()->last();
        }

        return null;
    }
}