<?php

namespace App\Service\Multimedia;

use App\DTO\MultimediaDTO;
use App\Entity\MultimediaPerformer;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Enum\MultimediaStatusEnum;
use App\Enum\MultimediaTypeEnum;
use App\Event\AddMultimediaEvent;
use App\Repository\UserRepository;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AddMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class AddMultimediaService extends AbstractService
{
    #[Required]
    public ?UserRepository $userRepository = null;

    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    #[Required]
    public ?ImageUploader $imageUploader = null;

    #[Required]
    public ?TrackUploader $trackUploader = null;

    #[Required]
    public ?ClipUploader $clipUploader = null;

    #[Required]
    public ?SubtitlesUploader $subtitlesUploader = null;

    /**
     * @param MultimediaDTO $multimediaDTO
     * @param User          $toUser
     *
     * @return JsonResponse
     */
    public function make(MultimediaDTO $multimediaDTO, User $toUser): JsonResponse
    {
        if (false === $this->validate($multimediaDTO)) {
            return $this->validator->getResponse();
        }

        $multimediaEntity = $multimediaDTO->getEntity();

        $multimediaEntity->setUser($toUser);
        $multimediaEntity->setStatus(MultimediaStatusEnum::MODERATION);

        foreach ($multimediaDTO->performers as $performerEmail) {
            $performer = $this->userRepository->getByEmail($performerEmail);

            if (null === $performer) {
                throw EntityNotFoundException::performer($performerEmail);
            }

            $multimediaPerformerEntity = new MultimediaPerformer();

            $multimediaPerformerEntity->setMultimedia($multimediaEntity);
            $multimediaPerformerEntity->setUser($performer);

            $multimediaEntity->addPerformer($multimediaPerformerEntity);
        }

        $this->eventDispatcher->dispatch(
            new AddMultimediaEvent($multimediaDTO, $multimediaEntity),
            EventEnum::BEFORE_ADD_MULTIMEDIA->value
        );

        $multimediaEntity->setMultimedia($this->uploadMultimediaToStorage($multimediaDTO, $toUser));
        $multimediaEntity->setImage($this->uploadPreviewToStorage($multimediaDTO, $toUser));
        $multimediaEntity->setSubtitles($this->uploadSubtitlesToStorage($multimediaDTO, $toUser));

        $this->em->persist($multimediaEntity);
        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new AddMultimediaEvent($multimediaDTO, $multimediaEntity),
            EventEnum::AFTER_ADD_MULTIMEDIA->value
        );

        return $this->responseCollection->successCreate('multimedia@successAddToModeration');
    }

    /**
     * @param MultimediaDTO $multimediaDTO
     * @param User          $toUser
     *
     * @return string
     */
    private function uploadPreviewToStorage(MultimediaDTO $multimediaDTO, User $toUser): string
    {
        $this->imageUploader->upload($multimediaDTO->image, [$toUser->getId()]);

        return $this->imageUploader->getUploadedFile()->last();
    }

    /**
     * @param MultimediaDTO $multimediaDTO
     * @param User          $toUser
     *
     * @return null|string
     */
    private function uploadMultimediaToStorage(MultimediaDTO $multimediaDTO, User $toUser): ?string
    {
        if (MultimediaTypeEnum::TRACK === $multimediaDTO->type) {
            $this->trackUploader->upload($multimediaDTO->multimedia, [$toUser->getId()]);

            return $this->trackUploader->getUploadedFile()->last();
        } elseif (MultimediaTypeEnum::CLIP === $multimediaDTO->type) {
            $this->clipUploader->upload($multimediaDTO->multimedia, [$toUser->getId()]);

            return $this->clipUploader->getUploadedFile()->last();
        }

        return null;
    }

    /**
     * @param MultimediaDTO $multimediaDTO
     * @param User          $toUser
     *
     * @return null|string
     */
    private function uploadSubtitlesToStorage(MultimediaDTO $multimediaDTO, User $toUser): ?string
    {
        if (null !== $multimediaDTO->subtitles) {
            $this->subtitlesUploader->upload($multimediaDTO->subtitles, [$toUser->getId()]);

            return $this->subtitlesUploader->getUploadedFile()->last();
        }

        return null;
    }
}