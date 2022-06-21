<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\MultimediaDTO;
use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\MultimediaStatusEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\MultimediaRepository;
use App\ResponseData\MultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Multimedia\AddMultimediaService;
use App\Service\Multimedia\SendOnAppealService;
use App\Service\Multimedia\SendOnModerationService;
use App\Service\Multimedia\UpdateMultimediaService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultimediaController.
 *
 * @package App\Controller\PublicAvailable
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
    public function myAll(MultimediaResponseData $multimediaResponseData, MultimediaRepository $multimediaRepository): JsonResponse
    {
        $multimediaResponseData->setEntities($multimediaRepository->findAllByUser($this->authorizedUser->getUser()));

        $multimediaResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaResponseData->getResponse());
    }

    /**
     * @param User                   $user
     * @param MultimediaResponseData $multimediaResponseData
     * @param MultimediaRepository   $multimediaRepository
     *
     * @return JsonResponse
     */
    #[Route('/{user_id<\d+>}/multimedia/all', methods: 'GET')]
    #[Authorization]
    public function userAll(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaResponseData $multimediaResponseData,
        MultimediaRepository $multimediaRepository
    ): JsonResponse {
        $multimediaResponseData->setEntities($multimediaRepository->findBy([
            'user' => $user,
            'status' => MultimediaStatusEnum::PUBLISHED->name
        ]));
        $multimediaResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaResponseData->getResponse());
    }

    /**
     * @param MultimediaDTO        $multimediaDTO
     * @param AddMultimediaService $addMultimediaService
     *
     * @return JsonResponse
     */
    #[Route('/multimedia/add', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function add(MultimediaDTO $multimediaDTO, AddMultimediaService $addMultimediaService): JsonResponse
    {
        return $addMultimediaService->make($multimediaDTO->collect(), $this->authorizedUser->getUser());
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
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
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
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function sendOnModeration(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendOnModerationService $sendOnModerationService
    ): JsonResponse {
        if ($multimedia->getUser() !== $this->authorizedUser->getUser()) {
            throw EntityNotFoundException::multimedia();
        }

        return $sendOnModerationService->make($multimedia);
    }

    /**
     * @param Multimedia          $multimedia
     * @param SendOnAppealService $sendOnAppealService
     *
     * @return JsonResponse
     */
    #[Route('/multimedia/{multimedia_id<\d+>}/send-on-appeal', methods: 'PATCH')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function sendOnAppeal(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendOnAppealService $sendOnAppealService
    ): JsonResponse {
        return $sendOnAppealService->make($multimedia);
    }
}