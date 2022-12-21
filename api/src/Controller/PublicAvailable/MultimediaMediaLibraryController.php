<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MultimediaMediaLibraryTransformer;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\MediaLibrary\MediaLibraryMultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\MediaLibrary\Multimedia\DeleteMultimediaMediaLibrary;
use App\UseCase\MediaLibrary\Multimedia\ShareMultimediaMediaLibraryWithFriend;
use App\UseCase\MediaLibrary\Multimedia\UpdateMultimediaMediaLibrary;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library')]
#[Authorization]
class MultimediaMediaLibraryController extends AbstractRestController
{
    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/edit', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryTransformer $transformer,
        UpdateMultimediaMediaLibrary $updateMultimediaMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        return $this->responseData(
            $responseData,
            $updateMultimediaMediaLibrary->process($transformer->transformFromRequest($multimediaMediaLibrary)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        DeleteMultimediaMediaLibrary $deleteMultimediaMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        return $this->responseData(
            $responseData,
            $deleteMultimediaMediaLibrary->process($multimediaMediaLibrary),
            PlatformCodeEnum::DELETED
        );
    }

    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/share/with-friend/{user_id<\d+>}', methods: Request::METHOD_PATCH)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS)]
    public function share(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        ShareMultimediaMediaLibraryWithFriend $shareMultimediaMediaLibraryWithFriend,
        MediaLibraryMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        if (!$friend->isFriend($this->getAuthorizedUser())) {
            throw EntityNotFoundException::friend();
        }

        return $this->responseData(
            $responseData,
            $shareMultimediaMediaLibraryWithFriend->share($multimediaMediaLibrary, $this->getAuthorizedUser(), $friend),
            PlatformCodeEnum::UPDATED
        );
    }

    private function throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser(MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        if (!$this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }
    }
}