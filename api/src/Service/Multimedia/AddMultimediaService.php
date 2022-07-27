<?php

namespace App\Service\Multimedia;

use App\DTO\MultimediaDTO;
use App\Entity\User;
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

        $multimedia = $multimediaDTO->getEntity();

        $multimedia->setUser($toUser);
        $multimedia->setDraftStatus();

        $this->setPerformersToMultimediaService->set($multimediaDTO->performers, $multimedia);

        $this->saveMultimediaService->make($multimediaDTO, $multimedia);

        return $this->responseCollection->successCreate('multimedia@successAdd');
    }
}