<?php

namespace App\Service\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\User;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreateAlbumService.
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class CreateAlbumService extends AbstractService
{
    #[Required]
    public ?SaveAlbumService $saveAlbumService = null;

    public function create(AlbumDto $albumDto, User $toUser): Album
    {
        $this->validate($albumDto);

        $album = $albumDto->getEntity();

        $album->setUser($toUser);

        $this->saveAlbumService->make($albumDto, $album);

        return $album;
    }

    public function request(AlbumDto $albumDto, User $toUser): JsonResponse
    {
        $this->create($albumDto, $toUser);

        return $this->responseCollection->successCreate('album@successCreate');
    }
}