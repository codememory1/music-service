<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MultimediaMediaLibraryEventTransformer;
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
#[Authorization]
#[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT)]
class MultimediaMediaLibraryEventController extends AbstractRestController
{
    #[Route('/{multimediaMediaLibrary_id<\d+>}/event/add', methods: 'POST')]
    public function add(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryEventTransformer $multimediaMediaLibraryEventTransformer,
        AddMultimediaMediaLibraryEventService $addMultimediaMediaLibraryEventService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }

        return $addMultimediaMediaLibraryEventService->request(
            $multimediaMediaLibraryEventTransformer->transformFromRequest(),
            $multimediaMediaLibrary
        );
    }

    #[Route('/event/{multimediaMediaLibraryEvent_id}/edit', methods: 'PUT')]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaEvent')] MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent,
        MultimediaMediaLibraryEventTransformer $multimediaMediaLibraryEventTransformer,
        UpdateMultimediaMediaLibraryEventService $updateMultimediaMediaLibraryEventService
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($multimediaMediaLibraryEvent);

        return $updateMultimediaMediaLibraryEventService->request(
            $multimediaMediaLibraryEventTransformer->transformFromRequest($multimediaMediaLibraryEvent),
            $multimediaMediaLibraryEvent->getMultimediaMediaLibrary()
        );
    }

    #[Route('/event/{multimediaMediaLibraryEvent_id}/delete', methods: 'DELETE')]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaEvent')] MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent,
        DeleteMultimediaMediaLibraryEventService $deleteMultimediaMediaLibraryEventService
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($multimediaMediaLibraryEvent);

        return $deleteMultimediaMediaLibraryEventService->request($multimediaMediaLibraryEvent);
    }

    private function throwIfEventNotBelongsAuthorizedUser(MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent): void
    {
        $mediaLibraryFromEvent = $multimediaMediaLibraryEvent->getMultimediaMediaLibrary()->getMediaLibrary();

        if (false === $this->getAuthorizedUser()->isMediaLibraryBelongs($mediaLibraryFromEvent)) {
            throw EntityNotFoundException::multimediaEvent();
        }
    }
}