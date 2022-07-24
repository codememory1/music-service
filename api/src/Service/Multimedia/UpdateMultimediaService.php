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

        $multimediaEntity = $multimediaDTO->getEntity();

        if ($multimediaEntity->isPublished() || $multimediaEntity->isModeration() || $multimediaEntity->isAppeal()) {
            throw MultimediaException::badUpdateInStatus($multimediaEntity->getStatus());
        }

        $this->setPerformersToMultimediaService->set($multimediaDTO->performers, $multimediaEntity);

        $this->saveMultimediaService->make($multimediaDTO, $multimediaEntity);

        return $this->responseCollection->successUpdate('multimedia@successUpdate');
    }
}