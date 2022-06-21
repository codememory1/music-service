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
use App\Service\Multimedia\AppealCanceledService;
use App\Service\Multimedia\PublishMultimediaService;
use App\Service\Multimedia\SendOnModerationService;
use App\Service\Multimedia\UnpublishMultimediaService;
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
class MultimediaController extends AbstractRestController
{
    /**
     * @param MultimediaResponseData $multimediaResponseData
     * @param MultimediaRepository   $multimediaRepository
     *
     * @return JsonResponse
     */
    #[Route('/multimedia/all', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA)]
    public function all(MultimediaResponseData $multimediaResponseData, MultimediaRepository $multimediaRepository): JsonResponse
    {
        $multimediaResponseData->setEntities($multimediaRepository->findAll());
        $multimediaResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaResponseData->getResponse());
    }

    /**
     * @param Multimedia             $multimedia
     * @param MultimediaResponseData $multimediaResponseData
     *
     * @return JsonResponse
     */
    #[Route('/multimedia/{multimedia_id<\d+>}/read', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaResponseData $multimediaResponseData
    ): JsonResponse {
        $multimediaResponseData->setEntities($multimedia);
        $multimediaResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaResponseData->getResponse(true));
    }

    /**
     * @param User                 $user
     * @param MultimediaDTO        $multimediaDTO
     * @param AddMultimediaService $addMultimediaService
     *
     * @return JsonResponse
     */
    #[Route('/{user_id<\d+>}/multimedia/add', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_TO_USER)]
    public function add(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaDTO $multimediaDTO,
        AddMultimediaService $addMultimediaService
    ): JsonResponse {
        $this->authorizedUser->setUser($user);

        if (false === $this->authorizedUser->isSubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)) {
            throw MultimediaException::badAddMultimediaToUserInvalid();
        }

        return $addMultimediaService->make($multimediaDTO->collect(), $user);
    }

    /**
     * @param Multimedia              $multimedia
     * @param MultimediaDTO           $multimediaDTO
     * @param UpdateMultimediaService $updateMultimediaService
     *
     * @return JsonResponse
     */
    #[Route('/multimedia/{multimedia_id<\d+>}/edit', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaDTO $multimediaDTO,
        UpdateMultimediaService $updateMultimediaService
    ): JsonResponse {
        $multimediaDTO->setEntity($multimedia);

        return $updateMultimediaService->make($multimediaDTO->collect());
    }

    /**
     * @param Multimedia              $multimedia
     * @param SendOnModerationService $sendOnModerationService
     *
     * @return JsonResponse
     */
    #[Route('/multimedia/{multimedia_id<\d+>}/send-on-moderation', methods: 'PATCH')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::MULTIMEDIA_STATUS_CONTROL_TO_USER)]
    public function sendOnModeration(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendOnModerationService $sendOnModerationService
    ): JsonResponse {
        return $sendOnModerationService->make($multimedia);
    }

    /**
     * @param Multimedia               $multimedia
     * @param PublishMultimediaService $publishMultimediaService
     *
     * @return JsonResponse
     */
    #[Route('/multimedia/{multimedia_id<\d+>}/publish', methods: 'PATCH')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::MULTIMEDIA_STATUS_CONTROL_TO_USER)]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        PublishMultimediaService $publishMultimediaService
    ): JsonResponse {
        return $publishMultimediaService->make($multimedia);
    }

    /**
     * @param Multimedia                 $multimedia
     * @param UnpublishMultimediaService $unpublishMultimediaService
     *
     * @return JsonResponse
     */
    #[Route('/multimedia/{multimedia_id<\d+>}/unpublish', methods: 'PATCH')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::MULTIMEDIA_STATUS_CONTROL_TO_USER)]
    public function unpublish(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        UnpublishMultimediaService $unpublishMultimediaService
    ): JsonResponse {
        return $unpublishMultimediaService->make($multimedia);
    }

    /**
     * @param Multimedia            $multimedia
     * @param AppealCanceledService $appealCanceledService
     *
     * @return JsonResponse
     */
    #[Route('/multimedia/{multimedia_id<\d+>}/appeal-canceled', methods: 'PATCH')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::MULTIMEDIA_STATUS_CONTROL_TO_USER)]
    public function appealCanceled(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        AppealCanceledService $appealCanceledService
    ): JsonResponse {
        return $appealCanceledService->make($multimedia);
    }
}