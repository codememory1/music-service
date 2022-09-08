<?php

namespace App\Service\MultimediaListeningHistory;

use App\Entity\MultimediaListeningHistory;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DeleteListenService extends AbstractService
{
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