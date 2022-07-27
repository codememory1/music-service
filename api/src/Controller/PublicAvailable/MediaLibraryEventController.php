<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\MediaLibraryEventDTO;
use App\Entity\MediaLibrary;
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
#[Authorization]
#[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT)]
class MediaLibraryEventController extends AbstractRestController
{
    #[Route('/add', methods: 'POST')]
    public function add(MediaLibraryEventDTO $mediaLibraryEventDTO, AddMediaLibraryEventService $addMediaLibraryEventService): JsonResponse
    {
        return $addMediaLibraryEventService->make(
            $mediaLibraryEventDTO->collect(),
            $this->getAuthorizedUser()->getMediaLibrary()
        );
    }

    #[Route('/{mediaLibraryEvent_id<\d+>}/edit', methods: 'PUT')]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibraryEvent')] MediaLibraryEvent $mediaLibraryEvent,
        MediaLibraryEventDTO $mediaLibraryEventDTO,
        UpdateMediaLibraryEventService $updateMediaLibraryEventService
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($mediaLibraryEvent->getMediaLibrary());

        $mediaLibraryEventDTO->setEntity($mediaLibraryEvent);
        $mediaLibraryEventDTO->collect();

        return $updateMediaLibraryEventService->make($mediaLibraryEventDTO, $this->getAuthorizedUser()->getMediaLibrary());
    }

    #[Route('/{mediaLibraryEvent_id<\d+>}/delete', methods: 'DELETE')]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibraryEvent')] MediaLibraryEvent $mediaLibraryEvent,
        DeleteMediaLibraryEventService $deleteMediaLibraryEventService
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($mediaLibraryEvent->getMediaLibrary());

        return $deleteMediaLibraryEventService->make($mediaLibraryEvent);
    }

    private function throwIfEventNotBelongsAuthorizedUser(MediaLibrary $mediaLibrary): void
    {
        if (false === $this->getAuthorizedUser()->isMediaLibraryBelongs($mediaLibrary)) {
            throw EntityNotFoundException::mediaLibraryEvent();
        }
    }
}