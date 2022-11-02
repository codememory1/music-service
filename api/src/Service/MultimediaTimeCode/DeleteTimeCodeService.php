<?php

namespace App\Service\MultimediaTimeCode;

use App\Entity\MultimediaTimeCode;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DeleteTimeCodeService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {
    }

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