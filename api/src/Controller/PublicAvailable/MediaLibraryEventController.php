<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MediaLibraryEventTransformer;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\MediaLibrary\MediaLibraryEventResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\MediaLibraryEvent\AddMediaLibraryEvent;
use App\Service\MediaLibraryEvent\DeleteMediaLibraryEvent;
use App\Service\MediaLibraryEvent\UpdateMediaLibraryEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library/event')]
#[Authorization]
#[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT)]
class MediaLibraryEventController extends AbstractRestController
{
    #[Route('/add', methods: 'POST')]
    public function add(
        MediaLibraryEventTransformer $transformer,
        AddMediaLibraryEvent $addMediaLibraryEvent,
        MediaLibraryEventResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($addMediaLibraryEvent->add(
            $transformer->transformFromRequest(),
            $this->getAuthorizedUser()->getMediaLibrary()
        ));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/{mediaLibraryEvent_id<\d+>}/edit', methods: 'PUT')]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibraryEvent')] MediaLibraryEvent $mediaLibraryEvent,
        MediaLibraryEventTransformer $transformer,
        UpdateMediaLibraryEvent $updateMediaLibraryEvent,
        MediaLibraryEventResponseData $responseData
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($mediaLibraryEvent->getMediaLibrary());

        $responseData->setEntities($updateMediaLibraryEvent->update(
            $transformer->transformFromRequest($mediaLibraryEvent),
            $this->getAuthorizedUser()->getMediaLibrary()
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/{mediaLibraryEvent_id<\d+>}/delete', methods: 'DELETE')]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibraryEvent')] MediaLibraryEvent $mediaLibraryEvent,
        DeleteMediaLibraryEvent $deleteMediaLibraryEvent,
        MediaLibraryEventResponseData $responseData
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($mediaLibraryEvent->getMediaLibrary());

        $responseData->setEntities($deleteMediaLibraryEvent->delete($mediaLibraryEvent));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    private function throwIfEventNotBelongsAuthorizedUser(MediaLibrary $mediaLibrary): void
    {
        if (false === $this->getAuthorizedUser()->isMediaLibraryBelongs($mediaLibrary)) {
            throw EntityNotFoundException::mediaLibraryEvent();
        }
    }
}