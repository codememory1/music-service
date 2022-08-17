<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteFriendService extends AbstractService
{
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