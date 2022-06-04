<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Entity\User;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\AbstractService;
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

    /**
     * @param AlbumDTO $albumDTO
     * @param User     $toUser
     *
     * @return JsonResponse
     */
    public function make(AlbumDTO $albumDTO, User $toUser): JsonResponse
    {
        if (false === $this->validate($albumDTO)) {
            return $this->validator->getResponse();
        }

        $albumEntity = $albumDTO->getEntity();

        $albumEntity->setUser($toUser);
        $albumEntity->setImage($this->updateImageToStorage($albumDTO, $albumEntity, $toUser));

        $this->em->flush();

        return $this->responseCollection->successUpdate('album@successUpdate');
    }

    /**
     * @param AlbumDTO $albumDTO
     * @param Album    $album
     * @param User     $toUser
     *
     * @return null|string
     */
    private function updateImageToStorage(AlbumDTO $albumDTO, Album $album, User $toUser): ?string
    {
        $this->imageUploader->delete($album->getImage());
        $this->imageUploader->upload($albumDTO->image, [$toUser->getId()]);

        return $this->imageUploader->getUploadedFile()->last();
    }
}