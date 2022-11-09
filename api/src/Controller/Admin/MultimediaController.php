<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\MultimediaTransformer;
use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Exception\Http\MultimediaException;
use App\Repository\MultimediaRepository;
use App\ResponseData\Admin\Multimedia\MultimediaStatisticsResponseData;
use App\ResponseData\General\Multimedia\MultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Multimedia\AddMultimedia;
use App\Service\Multimedia\DeleteMultimedia;
use App\Service\Multimedia\UpdateMultimedia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class MultimediaController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA)]
    public function all(MultimediaResponseData $responseData, MultimediaRepository $multimediaRepository): JsonResponse
    {
        $responseData->setEntities($multimediaRepository->findAll());

        return $this->responseData($responseData);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/read', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($multimedia);

        return $this->responseData($responseData);
    }

    #[Route('/{user_id<\d+>}/multimedia/add', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_TO_USER)]
    public function add(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaTransformer $transformer,
        AddMultimedia $addMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        if (false === $user->isSubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)) {
            throw MultimediaException::badAddMultimediaToUserInvalid();
        }

        $responseData->setEntities($addMultimedia->add($transformer->transformFromRequest(), $user));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/edit', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaTransformer $transformer,
        UpdateMultimedia $updateMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateMultimedia->update($transformer->transformFromRequest($multimedia)));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        DeleteMultimedia $deleteMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deleteMultimedia->delete($multimedia));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/statistics', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_MULTIMEDIA_STATISTICS_TO_USER)]
    public function statistics(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaStatisticsResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($multimedia->getStatistic());

        return $this->responseData($responseData);
    }
}