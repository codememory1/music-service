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
use App\ResponseData\General\Multimedia\RunningMultimediaResponseData;
use App\ResponseData\Public\Multimedia\MultimediaStatisticsResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\Multimedia\Action\ToggleMultimediaPlayback;
use App\UseCase\Multimedia\AddMultimedia;
use App\UseCase\Multimedia\DeleteMultimedia;
use App\UseCase\Multimedia\UpdateMultimedia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class MultimediaController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: Request::METHOD_GET)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_MULTIMEDIA)]
    public function myAll(MultimediaResponseData $responseData, MultimediaRepository $multimediaRepository): JsonResponse
    {
        return $this->responseData($responseData, $multimediaRepository->findAllByUser($this->getAuthorizedUser()));
    }

    #[Route('/{user_id<\d+>}/multimedia/all', methods: Request::METHOD_GET)]
    public function userAll(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaResponseData $responseData,
        MultimediaRepository $multimediaRepository
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $user->getSetting()->isHideMyMultimedia() ? $multimediaRepository->findAnother($user) : []
        );
    }

    #[Route('/multimedia/add', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function add(
        MultimediaTransformer $transformer,
        AddMultimedia $addMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $addMultimedia->process($transformer->transformFromRequest(), $this->getAuthorizedUser()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/edit', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaTransformer $transformer,
        UpdateMultimedia $updateMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $updateMultimedia->process($transformer->transformFromRequest($multimedia)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_MULTIMEDIA)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        DeleteMultimedia $deleteMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        if (!$this->getAuthorizedUser()->isMultimediaBelongs($multimedia)) {
            throw EntityNotFoundException::multimedia();
        }

        return $this->responseData($responseData, $deleteMultimedia->process($multimedia), PlatformCodeEnum::DELETED);
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/play-pause', methods: Request::METHOD_PATCH)]
    public function playPause(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        ToggleMultimediaPlayback $toggleMultimediaPlayback,
        RunningMultimediaResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $toggleMultimediaPlayback->process($multimedia, $this->authorizedUser->getUserSession()),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/multimedia/{multimedia_id<\d+>}/statistics', methods: Request::METHOD_GET)]
    public function statistics(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        MultimediaStatisticsResponseData $responseData
    ): JsonResponse {
        if (!$this->getAuthorizedUser()->isMultimediaBelongs($multimedia)) {
            throw EntityNotFoundException::multimedia();
        }

        return $this->responseData($responseData, $multimedia->getStatistic());
    }
}