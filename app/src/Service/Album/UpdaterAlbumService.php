<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Entity\User;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\UpdaterCRUDService;
use App\Service\FileUploaderService;
use App\Service\Response\ApiResponseService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterAlbumService
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class UpdaterAlbumService extends UpdaterCRUDService
{

    /**
     * @param AlbumDTO            $albumDTO
     * @param ValidatorInterface  $validator
     * @param FileUploaderService $uploadedFileService
     * @param User|null           $user
     * @param string              $kernelProjectDir
     * @param int                 $id
     *
     * @return ApiResponseService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws UndefinedClassForDTOException
     */
    public function update(AlbumDTO $albumDTO, ValidatorInterface $validator, FileUploaderService $uploadedFileService, ?User $user, string $kernelProjectDir, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->messageNameNotExist = 'album_not_exist';
        $this->translationKeyNotExist = 'album@notExist';

        /** @var ApiResponseService|Album $createdEntity */
        $createdEntity = $this->make($albumDTO, ['id' => $id]);

        if ($createdEntity instanceof ApiResponseService) {
            return $createdEntity;
        }

        $this->deletePhoto($kernelProjectDir);

        $createdEntity->setPhoto($this->uploadPhoto($uploadedFileService, $user));

        return $this->push($createdEntity, 'album@successUpdate', true);

    }

    /**
     * @param FileUploaderService $uploadedFileService
     * @param User                $user
     *
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function uploadPhoto(FileUploaderService $uploadedFileService, User $user): string
    {

        $uploadedFileService->upload(function() use ($user) {
            return md5($user->getEmail() . random_bytes(10));
        });

        return $uploadedFileService->getUploadedFile()['filename_with_path'];

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

}