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
 * Class AppealCanceledService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class AppealCanceledService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function make(Multimedia $multimedia): JsonResponse
    {
        if (MultimediaStatusEnum::APPEAL->name !== $multimedia->getStatus()) {
            throw MultimediaException::badAppealCanceled();
        }

        $this->eventDispatcher->dispatch(
            new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::APPEAL_CANCELED),
            EventEnum::MULTIMEDIA_STATUS_CHANGE->value
        );

        return $this->responseCollection->successUpdate('multimedia@successAppealCanceled');
    }
}