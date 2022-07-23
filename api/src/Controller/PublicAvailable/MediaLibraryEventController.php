<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\MediaLibraryEventDTO;
use App\Entity\MediaLibraryEvent;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MediaLibraryEvent\AddMediaLibraryEventService;
use App\Service\MediaLibraryEvent\DeleteMediaLibraryEventService;
use App\Service\MediaLibraryEvent\UpdateMediaLibraryEventService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MediaLibraryEventController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/media-library/event')]
class MediaLibraryEventController extends AbstractRestController
{
    #[Route('/add', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT)]
    public function add(MediaLibraryEventDTO $mediaLibraryEventDTO, AddMediaLibraryEventService $addMediaLibraryEventService): JsonResponse
    {
        return $addMediaLibraryEventService->make(
            $mediaLibraryEventDTO->collect(),
            $this->authorizedUser->getUser()->getMediaLibrary()
        );
    }

    #[Route('/{mediaLibraryEvent_id<\d+>}/edit', methods: 'PUT')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibraryEvent')] MediaLibraryEvent $mediaLibraryEvent,
        MediaLibraryEventDTO $mediaLibraryEventDTO,
        UpdateMediaLibraryEventService $updateMediaLibraryEventService
    ): JsonResponse {
        if ($mediaLibraryEvent->getMediaLibrary()->getId() !== $this->authorizedUser->getUser()->getMediaLibrary()->getId()) {
            throw EntityNotFoundException::mediaLibraryEvent();
        }

        $mediaLibraryEventDTO->setEntity($mediaLibraryEvent);

        return $updateMediaLibraryEventService->make($mediaLibraryEventDTO->collect());
    }

    #[Route('/{mediaLibraryEvent_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibraryEvent')] MediaLibraryEvent $mediaLibraryEvent,
        DeleteMediaLibraryEventService $deleteMediaLibraryEventService
    ): JsonResponse {
        if ($mediaLibraryEvent->getMediaLibrary()->getId() !== $this->authorizedUser->getUser()->getMediaLibrary()->getId()) {
            throw EntityNotFoundException::mediaLibraryEvent();
        }

        return $deleteMediaLibraryEventService->make($mediaLibraryEvent);
    }
}