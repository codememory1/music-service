<?php

namespace App\EventListener\SaveMultimedia\After;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\MultimediaTypeEnum;
use App\Event\SaveMultimediaEvent;
use App\Message\MultimediaMetadataMessage;
use App\Rest\S3\Interfaces\S3UploaderInterface;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\MessageBusInterface;

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
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;

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
     * @var ImageUploader
     */
    private ImageUploader $imageUploader;

    /**
     * @param EntityManagerInterface $manager
     * @param MessageBusInterface    $bus
     * @param TrackUploader          $trackUploader
     * @param ClipUploader           $clipUploader
     * @param SubtitlesUploader      $subtitlesUploader
     * @param ImageUploader          $imageUploader
     */
    public function __construct(EntityManagerInterface $manager, MessageBusInterface $bus, TrackUploader $trackUploader, ClipUploader $clipUploader, SubtitlesUploader $subtitlesUploader, ImageUploader $imageUploader)
    {
        $this->em = $manager;
        $this->bus = $bus;
        $this->trackUploader = $trackUploader;
        $this->clipUploader = $clipUploader;
        $this->subtitlesUploader = $subtitlesUploader;
        $this->imageUploader = $imageUploader;
    }

    /**
     * @param SaveMultimediaEvent $event
     *
     * @return void
     */
    public function onAfterSaveMultimedia(SaveMultimediaEvent $event): void
    {
        $multimedia = $event->multimedia;

        $this->uploaderSetup($this->trackUploader, $multimedia->getUser(), $multimedia);
        $this->uploaderSetup($this->clipUploader, $multimedia->getUser(), $multimedia);
        $this->uploaderSetup($this->subtitlesUploader, $multimedia->getUser(), $multimedia);
        $this->uploaderSetup($this->imageUploader, $multimedia->getUser(), $multimedia);

        $multimedia->setMultimedia($this->uploadMultimediaToStorage(
            $multimedia,
            $event->multimediaDTO->multimedia
        ));
        $multimedia->setSubtitles($this->uploadSubtitlesToStorage(
            $multimedia,
            $event->multimediaDTO->subtitles
        ));
        $multimedia->setImage($this->uploadPreviewToStorage(
            $multimedia,
            $event->multimediaDTO->image
        ));

        $this->em->flush();

        $this->bus->dispatch(new MultimediaMetadataMessage($multimedia->getId()));
    }

    /**
     * @param Multimedia        $multimedia
     * @param null|UploadedFile $uploadedFile
     *
     * @return null|string
     */
    private function uploadMultimediaToStorage(Multimedia $multimedia, ?UploadedFile $uploadedFile): ?string
    {
        if (null !== $uploadedFile) {
            if (MultimediaTypeEnum::TRACK->name === $multimedia->getType()) {
                $this->trackUploader->save(
                    $multimedia->getMultimedia(),
                    $uploadedFile->getRealPath(),
                    $uploadedFile->getMimeType()
                );

                return $this->trackUploader->getUploadedFile()->last();
            } elseif (MultimediaTypeEnum::CLIP->name === $multimedia->getType()) {
                $this->clipUploader->save(
                    $multimedia->getMultimedia(),
                    $uploadedFile->getRealPath(),
                    $uploadedFile->getMimeType()
                );

                return $this->clipUploader->getUploadedFile()->last();
            }

            return null;
        }

        return null;
    }

    /**
     * @param Multimedia        $multimedia
     * @param null|UploadedFile $uploadedFile
     *
     * @return null|string
     */
    private function uploadSubtitlesToStorage(Multimedia $multimedia, ?UploadedFile $uploadedFile): ?string
    {
        if (null !== $multimedia->getSubtitles() && null !== $uploadedFile) {
            $this->subtitlesUploader->save(
                $multimedia->getSubtitles(),
                $uploadedFile->getRealPath(),
                $uploadedFile->getMimeType()
            );

            return $this->subtitlesUploader->getUploadedFile()->last();
        }

        return null;
    }

    /**
     * @param Multimedia        $multimedia
     * @param null|UploadedFile $uploadedFile
     *
     * @return null|string
     */
    private function uploadPreviewToStorage(Multimedia $multimedia, ?UploadedFile $uploadedFile): ?string
    {
        if (null !== $uploadedFile) {
            $this->imageUploader->save(
                $multimedia->getImage(),
                $uploadedFile->getRealPath(),
                $uploadedFile->getMimeType()
            );

            return $this->imageUploader->getUploadedFile()->last();
        }

        return null;
    }

    /**
     * @param S3UploaderInterface $uploader
     * @param User                $user
     * @param EntityInterface     $entity
     *
     * @return void
     */
    private function uploaderSetup(S3UploaderInterface $uploader, User $user, EntityInterface $entity): void
    {
        $uploader->setUser($user);
        $uploader->setEntity($entity);
    }
}