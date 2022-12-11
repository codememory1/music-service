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

    public function process(MediaLibrary $mediaLibrary, User $from, User $to): MediaLibrary
    {
        foreach ($mediaLibrary->getMultimedia() as $multimedia) {
            $this->shareMultimediaMediaLibraryWithFriend->share($multimedia, $from, $to);
        }

        return $mediaLibrary;
    }
}