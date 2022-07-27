<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
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

    public function make(AlbumDTO $albumDTO, User $toUser): JsonResponse
    {
        if (false === $this->validate($albumDTO)) {
            return $this->validator->getResponse();
        }

        $album = $albumDTO->getEntity();

        $album->setUser($toUser);

        $this->saveAlbumService->make($albumDTO, $album);

        return $this->responseCollection->successCreate('album@successCreate');
    }
}