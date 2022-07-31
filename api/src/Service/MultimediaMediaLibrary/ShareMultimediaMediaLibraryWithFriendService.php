<?php

namespace App\Service\MultimediaMediaLibrary;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Rest\Http\Exceptions\EntityExistException;
use App\Service\AbstractService;
use App\Service\Notification\NotificationCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class ShareMultimediaMediaLibraryWithFriendService.
 *
 * @package App\Service\MultimediaMediaLibrary
 *
 * @author  Codememory
 */
class ShareMultimediaMediaLibraryWithFriendService extends AbstractService
{
    #[Required]
    public ?NotificationCollection $notificationCollection = null;

    public function share(MultimediaMediaLibrary $multimediaMediaLibrary, User $from, User $friend): MultimediaMediaLibrary
    {
        $multimediaMediaLibrary = clone $multimediaMediaLibrary;
        $multimediaMediaLibrary->setMediaLibrary($friend->getMediaLibrary());

        $this->validate($multimediaMediaLibrary, static function(): void {
            throw EntityExistException::multimediaInMediaLibraryToUser();
        });

        $friend->getMediaLibrary()->addMultimedia($multimediaMediaLibrary);

        $this->flusherService->save();

        $this->notificationCollection->sharedMultimedia($from, $friend, $multimediaMediaLibrary);

        return $multimediaMediaLibrary;
    }

    public function request(MultimediaMediaLibrary $multimediaMediaLibrary, User $from, User $friend): JsonResponse
    {
        $this->share($multimediaMediaLibrary, $from, $friend);

        return $this->responseCollection->successUpdate('multimediaMediaLibrary@successShare');
    }
}