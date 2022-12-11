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
use App\UseCase\MediaLibrary\Multimedia\DeleteMultimediaMediaLibrary;
use App\UseCase\MediaLibrary\Multimedia\ShareMultimediaMediaLibraryWithFriend;
use App\UseCase\MediaLibrary\Multimedia\UpdateMultimediaMediaLibrary;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library')]
#[Authorization]
class MultimediaMediaLibraryController extends AbstractRestController
{
    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/edit', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryTransformer $transformer,
        UpdateMultimediaMediaLibrary $updateMultimediaMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): JsonResponse {
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        $responseData->setEntities($updateMultimediaMediaLibrary->process(
            $transformer->transformFromRequest($multimediaMediaLibrary)
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        DeleteMultimediaMediaLibrary $deleteMultimediaMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): JsonResponse {
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        $responseData->setEntities($deleteMultimediaMediaLibrary->process($multimediaMediaLibrary));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/share/with-friend/{user_id<\d+>}', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS)]
    public function share(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        ShareMultimediaMediaLibraryWithFriend $shareMultimediaMediaLibraryWithFriend,
        MediaLibraryMultimediaResponseData $responseData
    ): JsonResponse {
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        if (false === $friend->isFriend($this->getAuthorizedUser())) {
            throw EntityNotFoundException::friend();
        }

        $responseData->setEntities($shareMultimediaMediaLibraryWithFriend->share(
            $multimediaMediaLibrary,
            $this->getAuthorizedUser(),
            $friend
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    private function throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser(MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        if (false === $this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }
    }
}