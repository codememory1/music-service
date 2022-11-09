<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MultimediaTransformer;
use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\MultimediaRepository;
use App\ResponseData\General\Multimedia\MultimediaResponseData;
use App\ResponseData\Public\Multimedia\MultimediaStatisticsResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Multimedia\AddMultimedia;
use App\Service\Multimedia\DeleteMultimedia;
use App\Service\Multimedia\PlayPauseMultimedia;
use App\Service\Multimedia\UpdateMultimedia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class MultimediaController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: 'GET')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_MULTIMEDIA)]
    public function myAll(MultimediaResponseData $responseData, MultimediaRepository $multimediaRepository): JsonResponse
    {
        $responseData->setEntities($multimediaRepository->findAllByUser($this->getAuthorizedUser()));

        return $this->responseData($responseData);
    }

    #[Route('/{user_id<\d+>}/multimedia/all', methods: 'GET')]
    public function userAll(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaResponseData $responseData,
        MultimediaRepository $multimediaRepository
    ): JsonResponse {
        $responseData->setEntities($multimediaRepository->findAnother($user));

        return $this->responseData($responseData);
    }

    #[Route('/multimedia/add', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function add(
        MultimediaTransformer $transformer,
        AddMultimedia $addMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($addMultimedia->add(
            $transformer->transformFromRequest(),
            $this->getAuthorizedUser()
        ));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/edit', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA)]
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
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_MULTIMEDIA)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        DeleteMultimedia $deleteMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaBelongs($multimedia)) {
            throw EntityNotFoundException::multimedia();
        }

        $responseData->setEntities($deleteMultimedia->delete($multimedia));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/play-pause', methods: 'PATCH')]
    public function playPause(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        PlayPauseMultimedia $playPauseMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($playPauseMultimedia->playPause($multimedia, $this->authorizedUser->getUserSession()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/statistics', methods: Request::METHOD_GET)]
    public function statistics(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaStatisticsResponseData $responseData
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaBelongs($multimedia)) {
            throw EntityNotFoundException::multimedia();
        }

        $responseData->setEntities($multimedia->getStatistic());

        return $this->responseData($responseData);
    }
}