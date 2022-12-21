<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\MediaLibraryTransformer;
use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\MediaLibrary\MediaLibraryMultimediaResponseData;
use App\ResponseData\General\MediaLibrary\MediaLibraryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\MediaLibrary\CreateMediaLibrary;
use App\UseCase\MediaLibrary\UpdateMediaLibrary;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class MediaLibraryController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/media-library/multimedia/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_MEDIA_LIBRARY_TO_USER)]
    public function allMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MediaLibraryMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        if (null === $user->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        return $this->responseData($responseData, $user->getMediaLibrary()->getMultimedia());
    }

    #[Route('/{user_id<\d+>}/media-library/create', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::CREATE_MEDIA_LIBRARY_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MediaLibraryTransformer $transformer,
        CreateMediaLibrary $createMediaLibrary,
        MediaLibraryResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $createMediaLibrary->process($transformer->transformFromRequest(), $user),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/media-library/{mediaLibrary_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MEDIA_LIBRARY_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibrary')] MediaLibrary $mediaLibrary,
        MediaLibraryTransformer $transformer,
        UpdateMediaLibrary $updateMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $updateMediaLibrary->process($transformer->transformFromRequest($mediaLibrary)),
            PlatformCodeEnum::UPDATED
        );
    }
}