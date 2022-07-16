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
    public function make(Friend $friend): JsonResponse
    {
        $friend->setConfirmed();

        $this->em->flush();

        return $this->responseCollection->successUpdate('friend@successAccept');
    }
}