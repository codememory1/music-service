<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\MultimediaExternalServiceTransformer;
use App\Dto\Transformer\UpdateMultimediaExternalServiceTransformer;
use App\Entity\MultimediaExternalService;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
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

#[Route('/user')]
#[Authorization]
class MultimediaExternalServiceController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/multimedia-from-external-service/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_ALL_USER_MULTIMEDIA_EXTERNAL_SERVICE)]
    public function all(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaExternalServiceResponseData $responseData,
        MultimediaExternalServiceRepository $multimediaExternalServiceRepository
    ): JsonResponse {
        $responseData->setEntities($multimediaExternalServiceRepository->findAllByUser($user));

        return $this->responseData($responseData);
    }

    #[Route('/{user_id<\d+>}/multimedia-from-external-service/add', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::ADD_MULTIMEDIA_EXTERNAL_SERVICE_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaExternalServiceTransformer $transformer,
        CreateMultimediaFromExternalService $createMultimediaFromExternalService,
        MultimediaExternalServiceResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($createMultimediaFromExternalService->process(
            $transformer->transformFromRequest(),
            $user
        ));

        return $this->responseData($responseData);
    }

    #[Route('/{multimediaExternalService_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_EXTERNAL_SERVICE_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaFromExternalService')] MultimediaExternalService $multimediaExternalService,
        UpdateMultimediaExternalServiceTransformer $transformer,
        UpdateMultimediaFromExternalService $updateMultimediaFromExternalService,
        MultimediaExternalServiceResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateMultimediaFromExternalService->process(
            $transformer->transformFromRequest($multimediaExternalService)
        ));

        return $this->responseData($responseData);
    }

    #[Route('/multimedia-from-external-service/{multimediaExternalService_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_EXTERNAL_SERVICE_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaFromExternalService')] MultimediaExternalService $multimediaExternalService,
        DeleteMultimediaFromExternalService $deleteMultimediaFromExternalService,
        MultimediaExternalServiceResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deleteMultimediaFromExternalService->process($multimediaExternalService));

        return $this->responseData($responseData);
    }
}