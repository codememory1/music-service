<?php

namespace App\Service\PlaylistDirectory;

use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\PlaylistDirectory;
use App\Repository\MultimediaPlaylistRepository;
use App\Rest\Http\Exceptions\EntityExistException;
use App\Service\AbstractService;
use App\Service\Playlist\CheckExistMultimediaToPlaylistDirectoriesService;
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
    public ?MultimediaPlaylistRepository $multimediaPlaylistRepository = null;

    public function make(PlaylistDirectory $playlistDirectory, MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        $finedMultimediaPlaylist = $this->multimediaPlaylistRepository->findOneBy([
            'playlist' => $playlistDirectory->getPlaylist(),
            'multimediaMediaLibrary' => $multimediaMediaLibrary
        ]);
        $checkExistMultimediaToPlaylistDirectories = new CheckExistMultimediaToPlaylistDirectoriesService();

        $checkExistMultimediaToPlaylistDirectories->throwIfExist($playlistDirectory->getPlaylist()->getDirectories(), $multimediaMediaLibrary);

        if (null !== $finedMultimediaPlaylist) {
            throw EntityExistException::multimediaPlaylist();
        }

        $multimediaPlaylistDirectory = new MultimediaPlaylistDirectory();

        $multimediaPlaylistDirectory->setMultimediaMediaLibrary($multimediaMediaLibrary);

        $playlistDirectory->addMultimedia($multimediaPlaylistDirectory);

        $this->em->flush();

        return $this->responseCollection->successUpdate('playlistDirectory@successAddMultimedia');
    }
}