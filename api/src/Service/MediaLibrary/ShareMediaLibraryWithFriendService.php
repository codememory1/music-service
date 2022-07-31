<?php

namespace App\Service\MediaLibrary;

use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Service\AbstractService;
use App\Service\MultimediaMediaLibrary\ShareMultimediaMediaLibraryWithFriendService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class ShareMediaLibraryWithFriendService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class ShareMediaLibraryWithFriendService extends AbstractService
{
    #[Required]
    public ?ShareMultimediaMediaLibraryWithFriendService $shareMultimediaMediaLibraryWithFriendService = null;

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