<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteFriendService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

    public function delete(Friend $friendship): Friend
    {
        $this->flusherService->remove($friendship);

        return $friendship;
    }

    public function request(Friend $friendship): JsonResponse
    {
        $this->delete($friendship);

        return $this->responseCollection->successDelete('friend@successDelete');
    }
}