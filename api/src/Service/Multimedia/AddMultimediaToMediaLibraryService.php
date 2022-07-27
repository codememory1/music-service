<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AddMultimediaToMediaLibraryService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class AddMultimediaToMediaLibraryService extends AbstractService
{
    /**
     * @param Multimedia $multimedia
     * @param User       $toUser
     *
     * @return JsonResponse
     */
    public function make(Multimedia $multimedia, User $toUser): JsonResponse
    {
        $multimediaMediaLibrary = new MultimediaMediaLibrary();

        if (null === $toUser->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        $multimediaMediaLibrary->setMediaLibrary($toUser->getMediaLibrary());
        $multimediaMediaLibrary->setMultimedia($multimedia);

        if (false === $this->validate($multimediaMediaLibrary)) {
            return $this->validator->getResponse();
        }

        $toUser->getMediaLibrary()->addMultimedia($multimediaMediaLibrary);

        $this->flusherService->save();

        return $this->responseCollection->successCreate('multimediaMediaLibrary@successAdd');
    }
}