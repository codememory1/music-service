<?php

namespace App\MessageHandler;

use App\Entity\Multimedia;
use App\Entity\MultimediaMetadata;
use App\Enum\MultimediaTypeEnum;
use App\Message\MultimediaMetadataMessage;
use App\Rest\S3\UploadedObject;
use Doctrine\ORM\EntityManagerInterface;
use FFMpeg\FFProbe;
use FFMpeg\FFProbe\DataMapping\Stream;
use FFMpeg\FFProbe\DataMapping\StreamCollection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use wapmorgan\MediaFile\Adapters\VideoAdapter;
use wapmorgan\MediaFile\Exceptions\FileAccessException;

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
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var UploadedObject
     */
    private UploadedObject $uploadedObject;

    /**
     * @param EntityManagerInterface $manager
     * @param UploadedObject         $uploadedObject
     */
    public function __construct(EntityManagerInterface $manager, UploadedObject $uploadedObject)
    {
        $this->em = $manager;
        $this->uploadedObject = $uploadedObject;
    }

    /**
     * @param Multimedia $multimedia
     * @param Stream     $stream
     *
     * @return void
     */
    private function trackHandler(Multimedia $multimedia, Stream $stream): void
    {
        $multimediaMetadataEntity = new MultimediaMetadata();

        $multimediaMetadataEntity->setDuration((float) $stream->get('duration'));
        $multimediaMetadataEntity->setBitrate((int) $stream->get('bit_rate'));

        $multimedia->setMetadata($multimediaMetadataEntity);
    }

    /**
     * @param Multimedia   $multimedia
     * @param VideoAdapter $adapter
     *
     * @return void
     */
    private function clipHandler(Multimedia $multimedia, Stream $stream): void
    {
        $multimediaMetadataEntity = new MultimediaMetadata();

        $multimediaMetadataEntity->setDuration($stream->get('duration'));
        $multimediaMetadataEntity->setBitrate((int) $stream->get('bit_rate'));
        $multimediaMetadataEntity->setFramerate((int) $stream->get('nb_frames'));

        $multimedia->setMetadata($multimediaMetadataEntity);
    }

    /**
     * @param Multimedia       $multimedia
     * @param StreamCollection $streamCollection
     *
     * @return void
     */
    private function handlerTypes(Multimedia $multimedia, StreamCollection $streamCollection): void
    {
        switch ($multimedia->getType()) {
            case MultimediaTypeEnum::TRACK->name:
                $this->trackHandler($multimedia, $streamCollection->audios()->first());
                break;
            case MultimediaTypeEnum::CLIP->name:
                $this->clipHandler($multimedia, $streamCollection->videos()->first());
                break;
        }
    }

    /**
     * @throws FileAccessException
     */
    public function __invoke(MultimediaMetadataMessage $message): void
    {
        $multimediaRepository = $this->em->getRepository(Multimedia::class);
        $multimedia = $multimediaRepository->find($message->multimediaId);

        if (null !== $multimedia->getMultimedia()) {
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
}