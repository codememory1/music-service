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
 * Class SendOnModerationService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class SendOnModerationService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    /**
     * @param Multimedia $multimedia
     *
     * @return JsonResponse
     */
    public function make(Multimedia $multimedia): JsonResponse
    {
        if ($multimedia->getStatus() !== MultimediaStatusEnum::DRAFT->name) {
            throw MultimediaException::badSendOnModeration();
        }

        $this->eventDispatcher->dispatch(
            new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::MODERATION),
            EventEnum::MULTIMEDIA_STATUS_CHANGE->value
        );

        return $this->responseCollection->successUpdate('multimedia@successSendOnModeration');
    }
}