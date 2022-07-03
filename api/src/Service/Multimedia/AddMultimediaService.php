<?php

namespace App\Service\Multimedia;

use App\DTO\MultimediaDTO;
use App\Entity\User;
use App\Enum\MultimediaStatusEnum;
use App\Service\AbstractService;
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
    public ?SetPerformersToMultimediaService $setPerformersToMultimediaService = null;

    #[Required]
    public ?SaveMultimediaService $saveMultimediaService = null;

    public function make(MultimediaDTO $multimediaDTO, User $toUser): JsonResponse
    {
        if (false === $this->validate($multimediaDTO)) {
            return $this->validator->getResponse();
        }

        $multimediaEntity = $multimediaDTO->getEntity();

        $multimediaEntity->setUser($toUser);
        $multimediaEntity->setStatus(MultimediaStatusEnum::DRAFT);

        $this->setPerformersToMultimediaService->set($multimediaDTO->performers, $multimediaEntity);

        $this->saveMultimediaService->make($multimediaDTO, $multimediaEntity);

        return $this->responseCollection->successCreate('multimedia@successAdd');
    }
}