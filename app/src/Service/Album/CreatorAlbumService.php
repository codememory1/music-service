<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Entity\User;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\CreatorCRUDService;
use App\Service\FileUploaderService;
use App\Service\Response\ApiResponseService;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorAlbumService
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class CreatorAlbumService extends CreatorCRUDService
{

    /**
     * @param AlbumDTO            $albumDTO
     * @param ValidatorInterface  $validator
     * @param FileUploaderService $uploadedFileService
     * @param User|null           $user
     *
     * @return ApiResponseService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function create(AlbumDTO $albumDTO, ValidatorInterface $validator, FileUploaderService $uploadedFileService, ?User $user): ApiResponseService
    {

        $this->validator = $validator;

        /** @var ApiResponseService|Album $createdEntity */
        $createdEntity = $this->make($albumDTO);

        if ($createdEntity instanceof ApiResponseService) {
            return $createdEntity;
        }

        $createdEntity->setPhoto($this->uploadPhoto($uploadedFileService, $user));

        return $this->push($createdEntity, 'album@successCreate');

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

}