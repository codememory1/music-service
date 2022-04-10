<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Entity\User;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;
use App\Rest\S3\Uploader\ImageUploader;
use Exception;

/**
 * Class CreatorAlbumService.
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class CreatorAlbumService extends CreatorCRUD
{
    /**
     * @param AlbumDTO      $albumDTO
     * @param ImageUploader $imageUploader
     * @param User          $user
     *
     * @throws Exception
     *
     * @return Response
     */
    public function create(AlbumDTO $albumDTO, ImageUploader $imageUploader, User $user): Response
    {
        /** @var Album|Response $createdAlbum */
        $createdAlbum = $this->make($albumDTO);

        if ($createdAlbum instanceof Response) {
            return $createdAlbum;
        }

        $imageUploader->upload($albumDTO->photo, [$user->getEmail()]);

        $createdAlbum
            ->setUser($user)
            ->setPhoto($imageUploader->getUploadedFile()->first());

        return $this->manager->push($createdAlbum, 'album@successCreate');
    }
}