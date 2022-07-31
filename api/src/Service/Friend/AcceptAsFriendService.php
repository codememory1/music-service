<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AcceptAsFriendService.
 *
 * @package App\Service\Friend
 *
 * @author  Codememory
 */
class AcceptAsFriendService extends AbstractService
{
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