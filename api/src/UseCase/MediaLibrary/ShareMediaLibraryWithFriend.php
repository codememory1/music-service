<?php

namespace App\UseCase\MediaLibrary;

use App\Entity\MediaLibrary;
use App\Entity\User;
use App\UseCase\MediaLibrary\Multimedia\ShareMultimediaMediaLibraryWithFriend;

final class ShareMediaLibraryWithFriend
{
    public function __construct(
        private readonly ShareMultimediaMediaLibraryWithFriend $shareMultimediaMediaLibraryWithFriend
    ) {
    }

    public function process(User $from, User $to): MediaLibrary
    {
        foreach ($from->getMediaLibrary()->getMultimedia() as $multimedia) {
            $this->shareMultimediaMediaLibraryWithFriend->share($multimedia, $from, $to);
        }

        return $from->getMediaLibrary();
    }
}