<?php

namespace App\Service\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\User;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateAlbumService.
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class UpdateAlbumService extends AbstractService
{
    #[Required]
    public ?ImageUploader $imageUploader = null;

    public function update(AlbumDto $albumDto, User $toUser): Album
    {
        $this->validate($albumDto);

        $album = $albumDto->getEntity();

        $album->setUser($toUser);
        $album->setImage($this->uploadImage($albumDto->image, $album));

        $this->flusherService->save();

        return $album;
    }

    public function request(AlbumDto $albumDto, User $toUser): JsonResponse
    {
        $this->update($albumDto, $toUser);

        return $this->responseCollection->successUpdate('album@successUpdate');
    }

    private function uploadImage(UploadedFile $image, Album $album): ?string
    {
        return $this->simpleFileUpload($this->imageUploader, $album->getImage(), $image, $album);
    }
}