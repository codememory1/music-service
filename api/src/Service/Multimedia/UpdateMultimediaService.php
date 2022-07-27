<?php

namespace App\Service\Multimedia;

use App\DTO\MultimediaDTO;
use App\Rest\Http\Exceptions\MultimediaException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public ?SetPerformersToMultimediaService $setPerformersToMultimediaService = null;

    #[Required]
    public ?SaveMultimediaService $saveMultimediaService = null;

    public function make(MultimediaDTO $multimediaDTO): JsonResponse
    {
        if (false === $this->validate($multimediaDTO)) {
            return $this->validator->getResponse();
        }

        $multimedia = $multimediaDTO->getEntity();

        if ($multimedia->isPublished() || $multimedia->isModeration() || $multimedia->isAppeal()) {
            throw MultimediaException::badUpdateInStatus($multimedia->getStatus());
        }

        $this->setPerformersToMultimediaService->set($multimediaDTO->performers, $multimedia);

        $this->saveMultimediaService->make($multimediaDTO, $multimedia);

        return $this->responseCollection->successUpdate('multimedia@successUpdate');
    }
}