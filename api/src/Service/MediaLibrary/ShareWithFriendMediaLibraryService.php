<?php

namespace App\Service\MediaLibrary;

use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class ShareWithFriendMediaLibraryService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class ShareWithFriendMediaLibraryService extends AbstractService
{
    #[Required]
    public ?ShareWithFriendMultimediaMediaLibraryService $shareWithFriendMultimediaMediaLibraryService = null;

    public function make(MediaLibrary $mediaLibraryForShare, User $from, User $friend): JsonResponse
    {
        foreach ($mediaLibraryForShare->getMultimedia() as $multimedia) {
            $this->shareWithFriendMultimediaMediaLibraryService->make($multimedia, $from, $friend);
        }

        return $this->responseCollection->successUpdate('mediaLibrary@successShare');
    }
}