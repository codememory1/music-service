<?php

namespace App\MessageHandler;

use App\Entity\Multimedia;
use App\Entity\MultimediaMetadata;
use App\Message\MultimediaMetadataMessage;
use App\Rest\S3\UploadedObject;
use Doctrine\ORM\EntityManagerInterface;
use FFMpeg\FFProbe;
use FFMpeg\FFProbe\DataMapping\Stream;
use FFMpeg\FFProbe\DataMapping\StreamCollection;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class MultimediaMetadataMessageHandler.
 *
 * @package App\MessageHandler
 *
 * @author  Codememory
 */
#[AsMessageHandler]
class MultimediaMetadataMessageHandler
{
    private EntityManagerInterface $em;
    private UploadedObject $uploadedObject;

    public function __construct(EntityManagerInterface $manager, UploadedObject $uploadedObject)
    {
        $this->em = $manager;
        $this->uploadedObject = $uploadedObject;
    }

    #[Pure]
    private function getMultimediaMetadata(Multimedia $multimedia): ?MultimediaMetadata
    {
        if (null !== $multimedia->getMetadata()) {
            return $multimedia->getMetadata();
        }

        return new MultimediaMetadata();
    }

    private function trackHandler(Multimedia $multimedia, Stream $stream): void
    {
        $multimediaMetadataEntity = $this->getMultimediaMetadata($multimedia);

        $multimediaMetadataEntity->setDuration((float) $stream->get('duration'));
        $multimediaMetadataEntity->setBitrate((int) $stream->get('bit_rate'));

        $multimedia->setMetadata($multimediaMetadataEntity);
    }

    private function clipHandler(Multimedia $multimedia, Stream $stream): void
    {
        $multimediaMetadataEntity = $this->getMultimediaMetadata($multimedia);

        $multimediaMetadataEntity->setDuration($stream->get('duration'));
        $multimediaMetadataEntity->setBitrate((int) $stream->get('bit_rate'));
        $multimediaMetadataEntity->setFramerate((int) $stream->get('nb_frames'));

        $multimedia->setMetadata($multimediaMetadataEntity);
    }

    private function handlerTypes(Multimedia $multimedia, StreamCollection $streamCollection): void
    {
        if ($multimedia->isTrack()) {
            $this->trackHandler($multimedia, $streamCollection->audios()->first());
        } elseif ($multimedia->isClip()) {
            $this->clipHandler($multimedia, $streamCollection->videos()->first());
        }
    }

    public function __invoke(MultimediaMetadataMessage $message): void
    {
        $multimediaRepository = $this->em->getRepository(Multimedia::class);
        $multimedia = $multimediaRepository->find($message->multimediaId);

        $FFProbe = FFProbe::create();
        $multimediaStream = $this->uploadedObject->getObject($multimedia->getMultimedia(), true);
        $tempMultimedia = $this->uploadedObject->createTempFile($multimediaStream);
        $tempMultimediaMetadata = stream_get_meta_data($tempMultimedia);
        $tempMultimediaPath = $tempMultimediaMetadata['uri'];

        if ($FFProbe->isValid($tempMultimediaPath)) {
            $streamCollection = $FFProbe->streams($tempMultimediaPath);

            $this->handlerTypes($multimedia, $streamCollection);
        }

        $this->em->flush();
    }
}