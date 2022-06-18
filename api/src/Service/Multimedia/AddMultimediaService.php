<?php

namespace App\Service\Multimedia;

use App\DTO\MultimediaDTO;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Enum\MultimediaStatusEnum;
use App\Event\AddMultimediaEvent;
use App\Message\MultimediaMetadataMessage;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
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
    public ?AddMultimediaPerformersService $addMultimediaPerformersService = null;

    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    #[Required]
    public ?MessageBusInterface $bus = null;

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

        $this->addMultimediaPerformersService->make($multimediaDTO->performers, $multimediaEntity);

        $this->eventDispatcher->dispatch(
            new AddMultimediaEvent($multimediaDTO, $multimediaEntity),
            EventEnum::BEFORE_ADD_MULTIMEDIA->value
        );

        $this->em->persist($multimediaEntity);
        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new AddMultimediaEvent($multimediaDTO, $multimediaEntity),
            EventEnum::AFTER_ADD_MULTIMEDIA->value
        );
        $this->bus->dispatch(new MultimediaMetadataMessage($multimediaEntity->getId()));

        return $this->responseCollection->successCreate('multimedia@successAddToModeration');
    }
}