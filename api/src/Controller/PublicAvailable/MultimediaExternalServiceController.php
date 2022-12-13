<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MultimediaExternalServiceTransformer;
use App\Entity\MultimediaExternalService;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
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
    #[Route('/add', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA_FROM_EXTERNAL_SERVICE)]
    public function create(
        MultimediaExternalServiceTransformer $transformer,
        CreateMultimediaFromExternalService $createMultimediaFromExternalService,
        MultimediaExternalServiceResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($createMultimediaFromExternalService->process(
            $transformer->transformFromRequest(),
            $this->getAuthorizedUser()
        ));

        return $this->responseData($responseData);
    }

    #[Route('/{multimediaExternalService_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_FROM_EXTERNAL_SERVICE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaFromExternalService')] MultimediaExternalService $multimediaExternalService,
        MultimediaExternalServiceTransformer $transformer,
        UpdateMultimediaFromExternalService $updateMultimediaFromExternalService,
        MultimediaExternalServiceResponseData $responseData
    ): JsonResponse {
        if (false === $multimediaExternalService->getUser()->isCompare($this->getAuthorizedUser())) {
            throw EntityNotFoundException::multimediaFromExternalService();
        }

        $responseData->setEntities($updateMultimediaFromExternalService->process(
            $transformer->transformFromRequest($multimediaExternalService)
        ));

        return $this->responseData($responseData);
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

        $responseData->setEntities($deleteMultimediaFromExternalService->process($multimediaExternalService));

        return $this->responseData($responseData);
    }
}