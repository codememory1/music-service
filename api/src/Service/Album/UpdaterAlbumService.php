<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Entity\User;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;
use App\Service\FileUploaderService;
use Exception;

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
     * @param AlbumDTO            $albumDTO
     * @param FileUploaderService $uploadedFileService
     * @param null|User           $user
     * @param string              $kernelProjectDir
     * @param int                 $id
     *
     * @return Response
     * @throws Exception
     */
    public function update(AlbumDTO $albumDTO, FileUploaderService $uploadedFileService, ?User $user, string $kernelProjectDir, int $id): Response
    {
        $this->translationKeyNotExist = 'album@notExist';

        /** @var Album|Response $updatedAlbum */
        $updatedAlbum = $this->make($albumDTO, ['id' => $id]);

        if ($updatedAlbum instanceof Response) {
            return $updatedAlbum;
        }

        $this->deletePhoto($kernelProjectDir);

        $updatedAlbum->setPhoto($this->uploadPhoto($uploadedFileService, $user));

        return $this->manager->update($updatedAlbum, 'album@successUpdate');
    }

    /**
     * @param string $kernelProjectDir
     *
     * @return void
     */
    private function deletePhoto(string $kernelProjectDir): void
    {
        /** @var Album $album */
        $album = $this->finedEntity;

        $absolutePathPhoto = sprintf('%s/%s', $kernelProjectDir, $album->getPhoto());

        if (file_exists($absolutePathPhoto)) {
            unlink($absolutePathPhoto);
        }
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