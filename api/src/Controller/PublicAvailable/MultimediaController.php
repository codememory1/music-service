<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MultimediaTransformer;
use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\MultimediaRepository;
use App\ResponseData\MultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Multimedia\AddMultimediaService;
use App\Service\Multimedia\DeleteMultimediaService;
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
#[Authorization]
class MultimediaController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: 'GET')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_MULTIMEDIA)]
    public function myAll(MultimediaResponseData $multimediaResponseData, MultimediaRepository $multimediaRepository): JsonResponse
    {
        $multimediaResponseData->setEntities($multimediaRepository->findAllByUser($this->getAuthorizedUser()));
        $multimediaResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaResponseData->getResponse());
    }

    #[Route('/{user_id<\d+>}/multimedia/all', methods: 'GET')]
    public function userAll(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaResponseData $multimediaResponseData,
        MultimediaRepository $multimediaRepository
    ): JsonResponse {
        $multimediaResponseData->setEntities($multimediaRepository->findAnother($user));
        $multimediaResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaResponseData->getResponse());
    }

    #[Route('/multimedia/add', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function add(MultimediaTransformer $multimediaTransformer, AddMultimediaService $addMultimediaService): JsonResponse
    {
        return $addMultimediaService->request($multimediaTransformer->transformFromRequest(), $this->getAuthorizedUser());
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/edit', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaTransformer $multimediaTransformer,
        UpdateMultimediaService $updateMultimediaService
    ): JsonResponse {
        return $updateMultimediaService->request($multimediaTransformer->transformFromRequest($multimedia));
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_MULTIMEDIA)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        DeleteMultimediaService $deleteMultimediaService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaBelongs($multimedia)) {
            throw EntityNotFoundException::multimedia();
        }

        return $deleteMultimediaService->request($multimedia);
    }
}