<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\PlaylistDirectory;
use App\Repository\MultimediaPlaylistDirectoryRepository;
use App\Rest\Http\Exceptions\EntityExistException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AddMultimediaToPlaylistDirectoryService.
 *
 * @package App\Service\PlaylistDirectory
 *
 * @author  Codememory
 */
class AddMultimediaToPlaylistDirectoryService extends AbstractService
{
    #[Required]
    public ?MultimediaPlaylistDirectoryRepository $multimediaPlaylistDirectoryRepository = null;

    public function make(PlaylistDirectory $playlistDirectory, MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        $multimediaPlaylistDirectory = $this->multimediaPlaylistDirectoryRepository->findOneBy([
            'multimediaMediaLibrary' => $multimediaMediaLibrary
        ]);

        if (null !== $multimediaPlaylistDirectory) {
            throw EntityExistException::multimediaPlaylistDirectory();
        }

        $multimediaPlaylistDirectory = new MultimediaPlaylistDirectory();

        $multimediaPlaylistDirectory->setMultimediaMediaLibrary($multimediaMediaLibrary);

        $playlistDirectory->addMultimedia($multimediaPlaylistDirectory);

        $this->em->flush();

        return $this->responseCollection->successUpdate('playlistDirectory@successAddMultimedia');
    }
}