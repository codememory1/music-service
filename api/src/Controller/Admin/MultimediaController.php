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
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\Multimedia\AddMultimedia;
use App\UseCase\Multimedia\DeleteMultimedia;
use App\UseCase\Multimedia\UpdateMultimedia;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class MultimediaController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA)]
    public function all(MultimediaResponseData $responseData, MultimediaRepository $multimediaRepository): HttpResponseCollectorInterface
    {
        return $this->responseData($responseData, $multimediaRepository->findAll());
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/read', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $multimedia);
    }

    #[Route('/{user_id<\d+>}/multimedia/add', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_TO_USER)]
    public function add(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaTransformer $transformer,
        AddMultimedia $addMultimedia,
        MultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        if (!$user->isSubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)) {
            throw MultimediaException::badAddMultimediaToUserInvalid();
        }

        return $this->responseData(
            $responseData,
            $addMultimedia->process($transformer->transformFromRequest(), $user),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/edit', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaTransformer $transformer,
        UpdateMultimedia $updateMultimedia,
        MultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $updateMultimedia->process($transformer->transformFromRequest($multimedia)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        DeleteMultimedia $deleteMultimedia,
        MultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $deleteMultimedia->process($multimedia), PlatformCodeEnum::DELETED);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/statistics', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_MULTIMEDIA_STATISTICS_TO_USER)]
    public function statistics(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaStatisticsResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData($responseData, $multimedia->getStatistic());
    }
}