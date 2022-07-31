<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class DeleteMultimediaService extends AbstractService
{
    public function delete(Multimedia $multimedia): Multimedia
    {
        $this->flusherService->remove($multimedia);

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->delete($multimedia);

        return $this->responseCollection->successDelete('multimedia@successDelete');
    }
}