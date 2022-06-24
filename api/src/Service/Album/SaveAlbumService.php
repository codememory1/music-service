<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Enum\EventEnum;
use App\Event\SaveAlbumEvent;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SaveAlbumService.
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class SaveAlbumService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    /**
     * @param AlbumDTO $albumDTO
     * @param Album    $album
     *
     * @return void
     */
    public function make(AlbumDTO $albumDTO, Album $album): void
    {
        if (null === $album->getId()) {
            $this->em->persist($album);
        }

        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new SaveAlbumEvent($albumDTO, $album),
            EventEnum::SAVE_ALBUM->value
        );
    }
}