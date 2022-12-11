<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MultimediaMediaLibraryEventTransformer;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\MediaLibrary\MediaLibraryEventResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\MultimediaMediaLibrary\Event\AddMultimediaMediaLibraryEvent;
use App\UseCase\MultimediaMediaLibrary\Event\CancelMultimediaMediaLibraryEvent;
use App\UseCase\MultimediaMediaLibrary\Event\UpdateMultimediaMediaLibraryEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library/multimedia')]
#[Authorization]
#[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MULTIMEDIA_MEDIA_LIBRARY_EVENT)]
class MultimediaMediaLibraryEventController extends AbstractRestController
{
    #[Route('/{multimediaMediaLibrary_id<\d+>}/event/add', methods: 'POST')]
    public function add(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryEventTransformer $transformer,
        AddMultimediaMediaLibraryEvent $addMultimediaMediaLibraryEvent,
        MediaLibraryEventResponseData $responseData
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }

        $responseData->setEntities($addMultimediaMediaLibraryEvent->process(
            $transformer->transformFromRequest(),
            $multimediaMediaLibrary
        ));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/event/{multimediaMediaLibraryEvent_id}/edit', methods: 'PUT')]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaEvent')] MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent,
        MultimediaMediaLibraryEventTransformer $transformer,
        UpdateMultimediaMediaLibraryEvent $updateMultimediaMediaLibraryEvent,
        MediaLibraryEventResponseData $responseData
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($multimediaMediaLibraryEvent);

        $responseData->setEntities($updateMultimediaMediaLibraryEvent->process(
            $transformer->transformFromRequest($multimediaMediaLibraryEvent),
            $multimediaMediaLibraryEvent->getMultimediaMediaLibrary()
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/event/{multimediaMediaLibraryEvent_id}/delete', methods: 'DELETE')]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaEvent')] MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent,
        CancelMultimediaMediaLibraryEvent $cancelMultimediaMediaLibraryEvent,
        MediaLibraryEventResponseData $responseData
    ): JsonResponse {
        $this->throwIfEventNotBelongsAuthorizedUser($multimediaMediaLibraryEvent);

        $responseData->setEntities($cancelMultimediaMediaLibraryEvent->process($multimediaMediaLibraryEvent));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    private function throwIfEventNotBelongsAuthorizedUser(MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent): void
    {
        $mediaLibraryFromEvent = $multimediaMediaLibraryEvent->getMultimediaMediaLibrary()->getMediaLibrary();

        if (false === $this->getAuthorizedUser()->isMediaLibraryBelongs($mediaLibraryFromEvent)) {
            throw EntityNotFoundException::multimediaEvent();
        }
    }
}