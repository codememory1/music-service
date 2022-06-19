<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Rest\Http\Exceptions\MultimediaException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SendOnModerationService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class SendOnModerationService extends AbstractService
{
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

        $multimedia->setStatus(MultimediaStatusEnum::MODERATION);

        $this->em->flush();

        return $this->responseCollection->successUpdate('multimedia@successSendOnModeration');
    }
}