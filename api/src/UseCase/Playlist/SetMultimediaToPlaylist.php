<?php

namespace App\UseCase\Playlist;

use App\Entity\Multimedia;
use App\Entity\Playlist;
use App\Exception\Http\EntityExistException;
use App\Repository\MultimediaMediaLibraryRepository;
use App\Service\Playlist\ExistMultimediaToPlaylist;
use App\UseCase\MediaLibrary\Multimedia\AddMultimediaMediaLibraryToPlaylist;
use App\UseCase\Multimedia\Action\AddMultimediaToMediaLibrary;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class SetMultimediaToPlaylist
{
    public function __construct(
        private readonly MultimediaMediaLibraryRepository $multimediaMediaLibraryRepository,
        private readonly AddMultimediaToMediaLibrary $addMultimediaToMediaLibrary,
        private readonly ExistMultimediaToPlaylist $existMultimediaToPlaylist,
        private readonly AddMultimediaMediaLibraryToPlaylist $addMultimediaMediaLibraryToPlaylist
    ) {
    }

    /**
     * @param array<Multimedia> $multimediaList
     */
    public function process(array $multimediaList, Playlist $playlist): Collection
    {
        $addedMultimedia = new ArrayCollection();

        foreach ($multimediaList as $multimedia) {
            $mediaLibrary = $playlist->getMediaLibrary();
            $multimediaMediaLibrary = $this->multimediaMediaLibraryRepository->findInMediaLibrary($multimedia, $mediaLibrary);

            // If $multimedia does not exist in the media library, then add it initially to the media library, and then to the playlist
            if (null === $multimediaMediaLibrary) {
                $addedMultimedia->add($this->addMultimediaMediaLibraryToPlaylist->process(
                    $this->addMultimediaToMediaLibrary->process($multimedia, $mediaLibrary->getUser()),
                    $playlist
                ));
            } else {
                /** @var Playlist $in */
                if ($this->existMultimediaToPlaylist->existToEntirePlaylists($multimediaMediaLibrary, $in)) {
                    throw EntityExistException::multimediaPlaylist(['playlist' => $in->getTitle()]);
                }

                $addedMultimedia->add($this->addMultimediaMediaLibraryToPlaylist->process($multimediaMediaLibrary, $playlist));
            }
        }

        return $addedMultimedia;
    }
}