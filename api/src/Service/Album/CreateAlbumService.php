<?php

namespace App\Service\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\User;
use App\Rest\S3\Uploader\ImageUploader;
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
    public ?ImageUploader $imageUploader = null;

    public function create(AlbumDto $albumDto, User $toUser): Album
    {
        $this->validate($albumDto);

        $album = $albumDto->getEntity();

        $album->setUser($toUser);
        $album->setImage($this->simpleFileUpload($this->imageUploader, $album->getImage(), $albumDto->image, $album));

        $this->flusherService->save($album);

        return $album;
    }

    public function request(AlbumDto $albumDto, User $toUser): JsonResponse
    {
        $this->create($albumDto, $toUser);

        return $this->responseCollection->successCreate('album@successCreate');
    }
}