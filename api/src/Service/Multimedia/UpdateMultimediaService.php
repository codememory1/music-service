<?php

namespace App\Service\Multimedia;

use App\Dto\Transfer\MultimediaDto;
use App\Entity\Multimedia;
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
    public ?SaveMultimediaService $saveMultimediaService = null;

    public function update(MultimediaDto $multimediaDto): Multimedia
    {
        $this->validate($multimediaDto);

        $multimedia = $multimediaDto->getEntity();

        if ($multimedia->isPublished() || $multimedia->isModeration() || $multimedia->isAppeal()) {
            throw MultimediaException::badUpdateInStatus($multimedia->getStatus());
        }

        $this->saveMultimediaService->make($multimediaDto, $multimedia);

        return $multimedia;
    }

    public function request(MultimediaDto $multimediaDto): JsonResponse
    {
        $this->update($multimediaDto);

        return $this->responseCollection->successUpdate('multimedia@successUpdate');
    }
}