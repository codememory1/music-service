<?php

namespace App\MessageHandler;

use App\Entity\Multimedia;
use App\Enum\MultimediaTypeEnum;
use App\Message\MultimediaMetadataMessage;
use App\Message\MultimediaUploadFileMessage;
use App\Rest\S3\Interfaces\S3UploaderInterface;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MultimediaUploadFileMessageHandler.
 *
 * @package App\MessageHandler
 *
 * @author  Codememory
 */
#[AsMessageHandler]
class MultimediaUploadFileMessageHandler
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
     * @param S3UploaderInterface $uploader
     * @param Multimedia          $multimedia
     *
     * @return void
     */
    private function uploaderSetup(S3UploaderInterface $uploader, Multimedia $multimedia): void
    {
        $uploader->setUser($multimedia->getUser());
        $uploader->setEntity($multimedia);
    }

    /**
     * @param Multimedia $multimedia
     * @param array      $file
     *
     * @return null|string
     */
    private function uploadMultimediaToStorage(Multimedia $multimedia, array $file): ?string
    {
        if ([] !== $file) {
            if (MultimediaTypeEnum::TRACK->name === $multimedia->getType()) {
                $this->trackUploader->save($multimedia->getMultimedia(), $file['path'], $file['mimeType']);

                return $this->trackUploader->getUploadedFile()->last();
            } elseif (MultimediaTypeEnum::CLIP->name === $multimedia->getType()) {
                $this->clipUploader->upload($multimedia->getMultimedia(), $file['path'], $file['mimeType']);

                return $this->clipUploader->getUploadedFile()->last();
            }

            return null;
        }

        return null;
    }

    /**
     * @param Multimedia $multimedia
     * @param array      $file
     *
     * @return null|string
     */
    private function uploadSubtitlesToStorage(Multimedia $multimedia, array $file): ?string
    {
        if (null !== $multimedia->getSubtitles() && [] !== $file) {
            $this->subtitlesUploader->save($multimedia->getSubtitles(), $file['path'], $file['mimeType']);

            return $this->subtitlesUploader->getUploadedFile()->last();
        }

        return null;
    }

    /**
     * @param Multimedia $multimedia
     * @param array      $file
     *
     * @return null|string
     */
    private function uploadPreviewToStorage(Multimedia $multimedia, array $file): ?string
    {
        if ([] !== $file) {
            $this->imageUploader->save($multimedia->getImage(), $file['path'], $file['mimeType']);

            return $this->imageUploader->getUploadedFile()->last();
        }

        return null;
    }

    /**
     * @param MultimediaUploadFileMessage $message
     *
     * @return void
     */
    public function __invoke(MultimediaUploadFileMessage $message): void
    {
        $multimediaRepository = $this->em->getRepository(Multimedia::class);
        $multimedia = $multimediaRepository->find($message->multimediaId);

        if (null !== $multimedia) {
            $this->uploaderSetup($this->clipUploader, $multimedia);
            $this->uploaderSetup($this->trackUploader, $multimedia);
            $this->uploaderSetup($this->subtitlesUploader, $multimedia);
            $this->uploaderSetup($this->imageUploader, $multimedia);

            $multimedia->setMultimedia($this->uploadMultimediaToStorage(
                $multimedia,
                $message->getFile('multimedia')
            ));
            $multimedia->setSubtitles($this->uploadSubtitlesToStorage(
                $multimedia,
                $message->getFile('subtitles')
            ));
            $multimedia->setImage($this->uploadPreviewToStorage(
                $multimedia,
                $message->getFile('image')
            ));

            $this->em->flush();

            $this->bus->dispatch(new MultimediaMetadataMessage($multimedia->getId()));
        }
    }
}