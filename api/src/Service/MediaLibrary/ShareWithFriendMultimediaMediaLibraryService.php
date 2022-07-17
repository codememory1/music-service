<?php

namespace App\Service\MediaLibrary;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Rest\Http\Exceptions\EntityExistException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ShareWithFriendMultimediaMediaLibraryService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class ShareWithFriendMultimediaMediaLibraryService extends AbstractService
{
    public function make(MultimediaMediaLibrary $multimediaMediaLibrary, User $friend): JsonResponse
    {
        $multimediaMediaLibrary = clone $multimediaMediaLibrary;
        $multimediaMediaLibrary->setMediaLibrary($friend->getMediaLibrary());

        if (false === $this->validate($multimediaMediaLibrary)) {
            throw EntityExistException::multimediaInMediaLibraryToUser();
        }

        $friend->getMediaLibrary()->addMultimedia($multimediaMediaLibrary);

        $this->em->flush();

        return $this->responseCollection->successUpdate('multimediaMediaLibrary@successShare');
    }
}