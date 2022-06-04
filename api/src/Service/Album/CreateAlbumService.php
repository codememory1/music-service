<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
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
        $albumEntity->setImage($this->uploadImageToStorage($albumDTO, $toUser));

        $this->em->persist($albumEntity);
        $this->em->flush();

        return $this->responseCollection->successCreate('album@successCreate');
    }

    /**
     * @param AlbumDTO $albumDTO
     * @param User     $toUser
     *
     * @return string
     */
    private function uploadImageToStorage(AlbumDTO $albumDTO, User $toUser): string
    {
        $this->imageUploader->upload($albumDTO->image, [$toUser->getId()]);

        return $this->imageUploader->getUploadedFile()->last();
    }
}