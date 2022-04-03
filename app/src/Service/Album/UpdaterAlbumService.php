<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Entity\User;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;
use App\Service\FileUploaderService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     *
     * @return Response
     */
    public function update(AlbumDTO $albumDTO, FileUploaderService $uploadedFileService, ?User $user, string $kernelProjectDir, int $id): Response
    {
        $this->translationKeyNotExist = 'album@notExist';

        /** @var Album|Response $createdEntity */
        $createdEntity = $this->make($albumDTO, ['id' => $id]);

        if ($createdEntity instanceof Response) {
            return $createdEntity;
        }

        $this->deletePhoto($kernelProjectDir);

        $createdEntity->setPhoto($this->uploadPhoto($uploadedFileService, $user));

        return $this->manager->update($createdEntity, 'album@successUpdate');
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     *
     * @return string
     */
    private function uploadPhoto(FileUploaderService $uploadedFileService, User $user): string
    {
        $uploadedFileService->upload(fn() => md5($user->getEmail() . random_bytes(10)));

        return $uploadedFileService->getUploadedFile()['filename_with_path'];
    }
}