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
    public function add(Multimedia $multimedia, User $toUser): Multimedia
    {
        if (null === $toUser->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        $multimediaMediaLibrary = new MultimediaMediaLibrary();

        $multimediaMediaLibrary->setMediaLibrary($toUser->getMediaLibrary());
        $multimediaMediaLibrary->setMultimedia($multimedia);

        $this->validate($multimediaMediaLibrary);

        $this->flusherService->save($multimediaMediaLibrary);

        return $multimedia;
    }

    public function request(Multimedia $multimedia, User $toUser): JsonResponse
    {
        $this->add($multimedia, $toUser);

        return $this->responseCollection->successCreate('multimediaMediaLibrary@successAdd');
    }
}