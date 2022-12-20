<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MultimediaExternalServiceTransformer;
use App\Dto\Transformer\UpdateMultimediaExternalServiceTransformer;
use App\Entity\MultimediaExternalService;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\MultimediaExternalServiceRepository;
use App\ResponseData\General\Multimedia\ExternalService\MultimediaExternalServiceResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\Multimedia\ExternalService\CreateMultimediaFromExternalService;
use App\UseCase\Multimedia\ExternalService\DeleteMultimediaFromExternalService;
use App\UseCase\Multimedia\ExternalService\UpdateMultimediaFromExternalService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/multimedia-from-external-service')]
#[Authorization]
class MultimediaExternalServiceController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    public function all(MultimediaExternalServiceResponseData $responseData, MultimediaExternalServiceRepository $multimediaExternalServiceRepository): JsonResponse
    {
        return $this->responseData($responseData, $multimediaExternalServiceRepository->findAllByUser($this->getAuthorizedUser()));
    }

    #[Route('/add', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA_FROM_EXTERNAL_SERVICE)]
    public function create(
        MultimediaExternalServiceTransformer $transformer,
        CreateMultimediaFromExternalService $createMultimediaFromExternalService,
        MultimediaExternalServiceResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $createMultimediaFromExternalService->process($transformer->transformFromRequest(), $this->getAuthorizedUser()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/{multimediaExternalService_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_FROM_EXTERNAL_SERVICE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaFromExternalService')] MultimediaExternalService $multimediaExternalService,
        UpdateMultimediaExternalServiceTransformer $transformer,
        UpdateMultimediaFromExternalService $updateMultimediaFromExternalService,
        MultimediaExternalServiceResponseData $responseData
    ): JsonResponse {
        if (false === $multimediaExternalService->getUser()->isCompare($this->getAuthorizedUser())) {
            throw EntityNotFoundException::multimediaFromExternalService();
        }

        return $this->responseData(
            $responseData,
            $updateMultimediaFromExternalService->process($transformer->transformFromRequest($multimediaExternalService)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/{multimediaExternalService_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_FROM_EXTERNAL_SERVICE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaFromExternalService')] MultimediaExternalService $multimediaExternalService,
        DeleteMultimediaFromExternalService $deleteMultimediaFromExternalService,
        MultimediaExternalServiceResponseData $responseData
    ): JsonResponse {
        if (false === $multimediaExternalService->getUser()->isCompare($this->getAuthorizedUser())) {
            throw EntityNotFoundException::multimediaFromExternalService();
        }

        return $this->responseData(
            $responseData,
            $deleteMultimediaFromExternalService->process($multimediaExternalService),
            PlatformCodeEnum::DELETED
        );
    }
}