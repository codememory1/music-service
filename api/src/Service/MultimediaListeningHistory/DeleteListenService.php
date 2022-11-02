<?php

namespace App\Service\MultimediaListeningHistory;

use App\Entity\MultimediaListeningHistory;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DeleteListenService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {
    }

    public function delete(MultimediaListeningHistory $multimediaListeningHistory): MultimediaListeningHistory
    {
        $this->flusherService->remove($multimediaListeningHistory);

        return $multimediaListeningHistory;
    }

    public function request(MultimediaListeningHistory $multimediaListeningHistory): JsonResponse
    {
        $this->delete($multimediaListeningHistory);

        return $this->responseCollection->successDelete('multimediaListeningHistory@successDelete');
    }
}