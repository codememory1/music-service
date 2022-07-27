<?php

namespace App\Service\Friend;

use App\Entity\Friend;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteFriendService.
 *
 * @package App\Service\Friend
 *
 * @author  Codememory
 */
class DeleteFriendService extends AbstractService
{
    public function make(Friend $friendship): JsonResponse
    {
        $this->flusherService->addRemove($friendship)->save();

        return $this->responseCollection->successDelete('friend@successDelete');
    }
}