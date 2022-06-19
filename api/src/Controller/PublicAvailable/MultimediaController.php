<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\MultimediaDTO;
use App\Entity\User;
use App\Enum\MultimediaStatusEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\MultimediaRepository;
use App\ResponseData\MultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Multimedia\AddMultimediaService;
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
        $multimediaResponseData->setEntities($multimediaRepository->findBy([
            'user' => $this->authorizedUser->getUser()
        ]));
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
}