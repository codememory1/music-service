<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class AcceptAsFriendService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

    public function accept(Friend $friend): Friend
    {
        $friend->setConfirmed();

        $this->flusherService->save();

        return $friend;
    }

    public function request(Friend $friend): JsonResponse
    {
        $this->accept($friend);

        return $this->responseCollection->successUpdate('friend@successAccept');
    }
}