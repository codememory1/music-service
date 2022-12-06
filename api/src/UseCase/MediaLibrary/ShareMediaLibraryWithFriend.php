<?php

namespace App\UseCase\MediaLibrary;

use App\Entity\MediaLibrary;
use App\Entity\User;
use App\UseCase\MultimediaMediaLibrary\ShareMultimediaMediaLibraryWithFriend;

final class ShareMediaLibraryWithFriend
{
    public function __construct(
        private readonly ShareMultimediaMediaLibraryWithFriend $shareMultimediaMediaLibraryWithFriend
    ) {
    }

    public function process(MediaLibrary $mediaLibraryForShare, User $from, User $to): MediaLibrary
    {
        foreach ($mediaLibraryForShare->getMultimedia() as $multimedia) {
            $this->shareMultimediaMediaLibraryWithFriend->share($multimedia, $from, $to);
        }

        return $mediaLibraryForShare;
    }
}