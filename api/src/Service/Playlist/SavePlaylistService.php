<?php

namespace App\Service\Playlist;

use App\DTO\PlaylistDTO;
use App\Entity\Playlist;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Event\SavePlaylistEvent;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SavePlaylistService.
 *
 * @package App\Service\Playlist
 *
 * @author  Codememory
 */
class SavePlaylistService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    #[Required]
    public ?SetMultimediaToPlaylistService $setMultimediaToPlaylistService = null;

    public function make(PlaylistDTO $playlistDTO, Playlist $playlist, User $forUser): void
    {
        $playlist->setMediaLibrary($forUser->getMediaLibrary());

        $this->setMultimediaToPlaylistService->set($playlistDTO->multimedia, $playlist);

        if (null === $playlist->getId()) {
            $this->em->persist($playlist);
        }

        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new SavePlaylistEvent($playlist, $playlistDTO),
            EventEnum::SAVE_PLAYLIST->value
        );
    }
}