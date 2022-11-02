<?php

namespace App\Service\MediaLibrary;

use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Rest\Response\HttpResponseCollection;
use App\Service\MultimediaMediaLibrary\ShareMultimediaMediaLibraryWithFriendService;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShareMediaLibraryWithFriendService
{
    public function __construct(
        private readonly ShareMultimediaMediaLibraryWithFriendService $shareMultimediaMediaLibraryWithFriendService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

    public function share(MediaLibrary $mediaLibraryForShare, User $from, User $friend): MediaLibrary
    {
        foreach ($mediaLibraryForShare->getMultimedia() as $multimedia) {
            $this->shareMultimediaMediaLibraryWithFriendService->share($multimedia, $from, $friend);
        }

        return $mediaLibraryForShare;
    }

    public function request(MediaLibrary $mediaLibraryForShare, User $from, User $friend): JsonResponse
    {
        $this->share($mediaLibraryForShare, $from, $friend);

        return $this->responseCollection->successUpdate('mediaLibrary@successShare');
    }
}