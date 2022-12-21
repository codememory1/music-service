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
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\MediaLibrary\Event\AddMediaLibraryEvent;
use App\UseCase\MediaLibrary\Event\CancelMediaLibraryEvent;
use App\UseCase\MediaLibrary\Event\UpdateMediaLibraryEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library/event')]
#[Authorization]
#[SubscriptionPermission(SubscriptionPermissionEnum::CONTROL_MEDIA_LIBRARY_EVENT)]
class MediaLibraryEventController extends AbstractRestController
{
    #[Route('/add', methods: Request::METHOD_POST)]
    public function add(
        MediaLibraryEventTransformer $transformer,
        AddMediaLibraryEvent $addMediaLibraryEvent,
        MediaLibraryEventResponseData $responseData
    ): HttpResponseCollectorInterface {
        return $this->responseData(
            $responseData,
            $addMediaLibraryEvent->process($transformer->transformFromRequest(), $this->getAuthorizedUser()->getMediaLibrary()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/{mediaLibraryEvent_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibraryEvent')] MediaLibraryEvent $mediaLibraryEvent,
        MediaLibraryEventTransformer $transformer,
        UpdateMediaLibraryEvent $updateMediaLibraryEvent,
        MediaLibraryEventResponseData $responseData
    ): HttpResponseCollectorInterface {
        $this->throwIfEventNotBelongsAuthorizedUser($mediaLibraryEvent->getMediaLibrary());

        return $this->responseData(
            $responseData,
            $updateMediaLibraryEvent->process(
                $transformer->transformFromRequest($mediaLibraryEvent),
                $this->getAuthorizedUser()->getMediaLibrary()
            ),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/{mediaLibraryEvent_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibraryEvent')] MediaLibraryEvent $mediaLibraryEvent,
        CancelMediaLibraryEvent $cancelMediaLibraryEvent,
        MediaLibraryEventResponseData $responseData
    ): HttpResponseCollectorInterface {
        $this->throwIfEventNotBelongsAuthorizedUser($mediaLibraryEvent->getMediaLibrary());

        return $this->responseData($responseData, $cancelMediaLibraryEvent->process($mediaLibraryEvent), PlatformCodeEnum::DELETED);
    }

    private function throwIfEventNotBelongsAuthorizedUser(MediaLibrary $mediaLibrary): void
    {
        if (!$this->getAuthorizedUser()->isMediaLibraryBelongs($mediaLibrary)) {
            throw EntityNotFoundException::mediaLibraryEvent();
        }
    }
}