<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\MultimediaMediaLibraryTransformer;
use App\Entity\MultimediaMediaLibrary;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\MediaLibrary\MediaLibraryMultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\MediaLibrary\Multimedia\DeleteMultimediaMediaLibrary;
use App\UseCase\MediaLibrary\Multimedia\UpdateMultimediaMediaLibrary;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class MultimediaMediaLibraryController extends AbstractRestController
{
    #[Route('/media-library/multimedia/{multimediaMediaLibrary_id<\d+>}/edit', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryTransformer $transformer,
        UpdateMultimediaMediaLibrary $updateMultimediaMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $updateMultimediaMediaLibrary->process($transformer->transformFromRequest($multimediaMediaLibrary)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/media-library/multimedia/{multimediaMediaLibrary_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        DeleteMultimediaMediaLibrary $deleteMultimediaMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $deleteMultimediaMediaLibrary->process($multimediaMediaLibrary),
            PlatformCodeEnum::DELETED
        );
    }
}