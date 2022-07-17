<?php

namespace App\Service\MediaLibrary;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Rest\Http\Exceptions\EntityExistException;
use App\Service\AbstractService;
use App\Service\Notification\NotificationCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class ShareWithFriendMultimediaMediaLibraryService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class ShareWithFriendMultimediaMediaLibraryService extends AbstractService
{
    #[Required]
    public ?NotificationCollection $notificationCollection = null;

    public function make(MultimediaMediaLibrary $multimediaMediaLibrary, User $from, User $friend): JsonResponse
    {
        $multimediaMediaLibrary = clone $multimediaMediaLibrary;
        $multimediaMediaLibrary->setMediaLibrary($friend->getMediaLibrary());

        if (false === $this->validate($multimediaMediaLibrary)) {
            throw EntityExistException::multimediaInMediaLibraryToUser();
        }

        $friend->getMediaLibrary()->addMultimedia($multimediaMediaLibrary);

        $this->em->flush();

        $this->notificationCollection->sharedMultimedia($from, $friend, $multimediaMediaLibrary);

        return $this->responseCollection->successUpdate('multimediaMediaLibrary@successShare');
    }
}