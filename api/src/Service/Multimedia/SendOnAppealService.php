<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\EventEnum;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Rest\Http\Exceptions\MultimediaException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SendOnAppealService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class SendOnAppealService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function sendOnAppeal(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isUnpublished() && false === $multimedia->isAppealCanceled()) {
            throw MultimediaException::badSendOnAppeal($multimedia->getStatus());
        }

        $this->eventDispatcher->dispatch(
            new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::APPEAL),
            EventEnum::MULTIMEDIA_STATUS_CHANGE->value
        );

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->sendOnAppeal($multimedia);

        return $this->responseCollection->successUpdate('multimedia@successSendOnAppeal');
    }
}