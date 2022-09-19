<?php

namespace App\Service\MultimediaTimeCode;

use App\Entity\MultimediaTimeCode;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DeleteTimeCodeService extends AbstractService
{
    public function delete(MultimediaTimeCode $multimediaTimeCode): MultimediaTimeCode
    {
        $this->flusherService->remove($multimediaTimeCode);

        return $multimediaTimeCode;
    }

    public function request(MultimediaTimeCode $multimediaTimeCode): JsonResponse
    {
        $this->delete($multimediaTimeCode);

        return $this->responseCollection->successDelete('multimediaTimeCode@successDelete');
    }
}