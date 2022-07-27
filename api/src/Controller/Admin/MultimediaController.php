<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\MultimediaDTO;
use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\MultimediaRepository;
use App\ResponseData\MultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Rest\Http\Exceptions\MultimediaException;
use App\Service\Multimedia\AddMultimediaService;
use App\Service\Multimedia\DeleteMultimediaService;
use App\Service\Multimedia\UpdateMultimediaService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultimediaController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user')]
#[Authorization]
class MultimediaController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA)]
    public function all(MultimediaResponseData $multimediaResponseData, MultimediaRepository $multimediaRepository): JsonResponse
    {
        $multimediaResponseData->setEntities($multimediaRepository->findAll());
        $multimediaResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaResponseData->getResponse());
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/read', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaResponseData $multimediaResponseData
    ): JsonResponse {
        $multimediaResponseData->setEntities($multimedia);
        $multimediaResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaResponseData->getResponse(true));
    }

    #[Route('/{user_id<\d+>}/multimedia/add', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_TO_USER)]
    public function add(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaDTO $multimediaDTO,
        AddMultimediaService $addMultimediaService
    ): JsonResponse {
        $userHelper = $this->getManagerAuthorizedUser()->setUser($user);

        if (false === $userHelper->isSubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)) {
            throw MultimediaException::badAddMultimediaToUserInvalid();
        }

        return $addMultimediaService->make($multimediaDTO->collect(), $user);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/edit', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaDTO $multimediaDTO,
        UpdateMultimediaService $updateMultimediaService
    ): JsonResponse {
        $multimediaDTO->setEntity($multimedia);
        $multimediaDTO->collect();

        return $updateMultimediaService->make($multimediaDTO);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        DeleteMultimediaService $deleteMultimediaService
    ): JsonResponse {
        return $deleteMultimediaService->make($multimedia);
    }
}