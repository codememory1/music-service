<?php

namespace App\Service\MediaLibrary;

use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Service\MultimediaMediaLibrary\ShareMultimediaMediaLibraryWithFriend;

final class ShareMediaLibraryWithFriend
{
    public function __construct(
        private readonly ShareMultimediaMediaLibraryWithFriend $shareMultimediaMediaLibraryWithFriend
    ) {
    }

    public function share(MediaLibrary $mediaLibraryForShare, User $from, User $to): MediaLibrary
    {
        foreach ($mediaLibraryForShare->getMultimedia() as $multimedia) {
            $this->shareMultimediaMediaLibraryWithFriend->share($multimedia, $from, $to);
        }

        return $mediaLibraryForShare;
    }
}