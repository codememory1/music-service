<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\MultimediaMediaLibraryEventDTO;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MultimediaMediaLibraryEvent\AddMultimediaMediaLibraryEventService;
use App\Service\MultimediaMediaLibraryEvent\DeleteMultimediaMediaLibraryEventService;
use App\Service\MultimediaMediaLibraryEvent\UpdateMultimediaMediaLibraryEventService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultimediaMediaLibraryEventController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/media-library/multimedia')]
class MultimediaMediaLibraryEventController extends AbstractRestController
{
    #[Route('/{multimediaMediaLibrary_id<\d+>}/event/add', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT)]
    public function add(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryEventDTO $multimediaMediaLibraryEventDTO,
        AddMultimediaMediaLibraryEventService $addMultimediaMediaLibraryEventService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }

        return $addMultimediaMediaLibraryEventService->make($multimediaMediaLibraryEventDTO->collect(), $multimediaMediaLibrary);
    }

    #[Route('/event/{multimediaMediaLibraryEvent_id}/edit', methods: 'PUT')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaEvent')] MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent,
        MultimediaMediaLibraryEventDTO $multimediaMediaLibraryEventDTO,
        UpdateMultimediaMediaLibraryEventService $updateMultimediaMediaLibraryEventService
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($multimediaMediaLibraryEvent);

        $multimediaMediaLibraryEventDTO->setEntity($multimediaMediaLibraryEvent);
        $multimediaMediaLibraryEventDTO->collect();

        return $updateMultimediaMediaLibraryEventService->make(
            $multimediaMediaLibraryEventDTO,
            $multimediaMediaLibraryEvent->getMultimediaMediaLibrary()
        );
    }

    #[Route('/event/{multimediaMediaLibraryEvent_id}/delete', methods: 'DELETE')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaEvent')] MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent,
        DeleteMultimediaMediaLibraryEventService $deleteMultimediaMediaLibraryEventService
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($multimediaMediaLibraryEvent);

        return $deleteMultimediaMediaLibraryEventService->make($multimediaMediaLibraryEvent);
    }

    private function throwIfEventNotBelongsAuthorizedUser(MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent): void
    {
        $mediaLibraryFromEvent = $multimediaMediaLibraryEvent->getMultimediaMediaLibrary()->getMediaLibrary();

        if (false === $this->getAuthorizedUser()->isMediaLibraryBelongs($mediaLibraryFromEvent)) {
            throw EntityNotFoundException::multimediaEvent();
        }
    }
}