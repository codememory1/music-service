<?php

namespace App\Service\MultimediaMediaLibrary;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Exception\Http\EntityExistException;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Service\Notification\NotificationCollection;

final class ShareMultimediaMediaLibraryWithFriend
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly NotificationCollection $notificationCollection
    ) {
    }

    public function share(MultimediaMediaLibrary $multimediaMediaLibrary, User $from, User $to): MultimediaMediaLibrary
    {
        $multimediaMediaLibrary = clone $multimediaMediaLibrary;

        $multimediaMediaLibrary->setMediaLibrary($to->getMediaLibrary());

        $this->validator->validate($multimediaMediaLibrary, static function(): never {
            throw EntityExistException::multimediaInMediaLibraryToUser();
        });

        $to->getMediaLibrary()->addMultimedia($multimediaMediaLibrary);

        $this->flusher->save();

        $this->notificationCollection->sharedMultimedia($from, $to, $multimediaMediaLibrary);

        return $multimediaMediaLibrary;
    }
}