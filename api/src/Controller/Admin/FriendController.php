<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Entity\User;
use App\Repository\FriendRepository;
use App\ResponseData\FriendResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FriendController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user')]
class FriendController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/friend/all', methods: 'GET')]
    #[Authorization]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        FriendResponseData $friendResponseData,
        FriendRepository $friendRepository
    ): JsonResponse {
        $friendResponseData->setEntities($friendRepository->findByUser($user));

        return $this->responseCollection->dataOutput($friendResponseData->collect()->getResponse());
    }
}