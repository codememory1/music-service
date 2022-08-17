<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MediaLibraryEventTransformer;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Rest\Controller\AbstractRestController;
use App\Service\MediaLibraryEvent\AddMediaLibraryEventService;
use App\Service\MediaLibraryEvent\DeleteMediaLibraryEventService;
use App\Service\MediaLibraryEvent\UpdateMediaLibraryEventService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library/event')]
#[Authorization]
#[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT)]
class MediaLibraryEventController extends AbstractRestController
{
    #[Route('/add', methods: 'POST')]
    public function add(MediaLibraryEventTransformer $mediaLibraryEventTransformer, AddMediaLibraryEventService $addMediaLibraryEventService): JsonResponse
    {
        return $addMediaLibraryEventService->request(
            $mediaLibraryEventTransformer->transformFromRequest(),
            $this->getAuthorizedUser()->getMediaLibrary()
        );
    }

    #[Route('/{mediaLibraryEvent_id<\d+>}/edit', methods: 'PUT')]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibraryEvent')] MediaLibraryEvent $mediaLibraryEvent,
        MediaLibraryEventTransformer $mediaLibraryEventTransformer,
        UpdateMediaLibraryEventService $updateMediaLibraryEventService
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($mediaLibraryEvent->getMediaLibrary());

        return $updateMediaLibraryEventService->request(
            $mediaLibraryEventTransformer->transformFromRequest($mediaLibraryEvent),
            $this->getAuthorizedUser()->getMediaLibrary()
        );
    }

    #[Route('/{mediaLibraryEvent_id<\d+>}/delete', methods: 'DELETE')]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibraryEvent')] MediaLibraryEvent $mediaLibraryEvent,
        DeleteMediaLibraryEventService $deleteMediaLibraryEventService
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($mediaLibraryEvent->getMediaLibrary());

        return $deleteMediaLibraryEventService->request($mediaLibraryEvent);
    }

    private function throwIfEventNotBelongsAuthorizedUser(MediaLibrary $mediaLibrary): void
    {
        if (false === $this->getAuthorizedUser()->isMediaLibraryBelongs($mediaLibrary)) {
            throw EntityNotFoundException::mediaLibraryEvent();
        }
    }
}