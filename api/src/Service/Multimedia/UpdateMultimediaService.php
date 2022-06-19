<?php

namespace App\Service\Multimedia;

use App\DTO\MultimediaDTO;
use App\Enum\EventEnum;
use App\Event\AddMultimediaEvent;
use App\Message\MultimediaMetadataMessage;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class UpdateMultimediaService extends AbstractService
{
    #[Required]
    public ?SetPerformersToMultimediaService $addMultimediaPerformersService = null;

    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    #[Required]
    public ?MessageBusInterface $bus = null;

    /**
     * @param MultimediaDTO $multimediaDTO
     *
     * @return JsonResponse
     */
    public function make(MultimediaDTO $multimediaDTO): JsonResponse
    {
        if (false === $this->validate($multimediaDTO)) {
            return $this->validator->getResponse();
        }

        $multimediaEntity = $multimediaDTO->getEntity();

        $this->addMultimediaPerformersService->set($multimediaDTO->performers, $multimediaEntity);

        $this->eventDispatcher->dispatch(
            new AddMultimediaEvent($multimediaDTO, $multimediaEntity),
            EventEnum::BEFORE_ADD_MULTIMEDIA->value
        );

        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new AddMultimediaEvent($multimediaDTO, $multimediaEntity),
            EventEnum::AFTER_ADD_MULTIMEDIA->value
        );
        $this->bus->dispatch(new MultimediaMetadataMessage($multimediaEntity->getId()));

        return $this->responseCollection->successCreate('multimedia@successUpdate');
    }
}