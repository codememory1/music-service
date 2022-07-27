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
    public function make(Multimedia $multimedia): JsonResponse
    {
        $this->flusherService->addRemove($multimedia)->save();

        return $this->responseCollection->successDelete('multimedia@successDelete');
    }
}