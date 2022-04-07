<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Entity\User;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;
use App\Service\FileUploaderService;
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
     * @param AlbumDTO            $albumDTO
     * @param FileUploaderService $uploadedFileService
     * @param User                $user
     *
     * @return Response
     * @throws Exception
     */
    public function create(AlbumDTO $albumDTO, FileUploaderService $uploadedFileService, User $user): Response
    {
        /** @var Album|Response $createdAlbum */
        $createdAlbum = $this->make($albumDTO);

        if ($createdAlbum instanceof Response) {
            return $createdAlbum;
        }

        $createdAlbum->setPhoto($this->uploadPhoto($uploadedFileService, $user));

        return $this->manager->push($createdAlbum, 'album@successCreate');
    }

    /**
     * @param FileUploaderService $uploadedFileService
     * @param User                $user
     *
     * @return string
     * @throws Exception
     */
    private function uploadPhoto(FileUploaderService $uploadedFileService, User $user): string
    {
        return '';
    }
}