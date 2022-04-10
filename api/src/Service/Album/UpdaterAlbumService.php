<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;
use App\Rest\S3\Uploader\ImageUploader;

/**
 * Class UpdaterAlbumService.
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class UpdaterAlbumService extends UpdaterCRUD
{
    /**
     * @param AlbumDTO      $albumDTO
     * @param ImageUploader $imageUploader
     * @param int           $id
     *
     * @return Response
     */
    public function update(AlbumDTO $albumDTO, ImageUploader $imageUploader, int $id): Response
    {
        $this->translationKeyNotExist = 'album@notExist';

        /** @var Album|Response $updatedAlbum */
        $updatedAlbum = $this->make($albumDTO, ['id' => $id]);

        if ($updatedAlbum instanceof Response) {
            return $updatedAlbum;
        }

        $this->updatePhoto($albumDTO, $imageUploader, $updatedAlbum);

        return $this->manager->update($updatedAlbum, 'album@successUpdate');
    }

    /**
     * @param AlbumDTO      $albumDTO
     * @param ImageUploader $imageUploader
     * @param Album         $album
     *
     * @return void
     */
    private function updatePhoto(AlbumDTO $albumDTO, ImageUploader $imageUploader, Album $album): void
    {
        $imageUploader->delete($album->getPhoto());
        $imageUploader->upload($albumDTO->photo, ['email' => $album->getUser()->getEmail()]);

        $album->setPhoto($imageUploader->getUploadedFile()->first());
    }
}