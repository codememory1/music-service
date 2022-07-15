<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Friend\AddAsFriendService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FriendController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user')]
class FriendController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/add-as-friend', methods: 'PATCH')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_AS_FRIEND)]
    public function addAsFriend(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        AddAsFriendService $addAsFriendService
    ): JsonResponse {
        return $addAsFriendService->make($this->authorizedUser->getUser(), $friend);
    }
}