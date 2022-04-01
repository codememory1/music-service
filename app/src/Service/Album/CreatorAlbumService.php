<?php

namespace App\Service\Album;

use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Entity\User;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;
use App\Service\FileUploaderService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class CreatorAlbumService
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
	 * @param User|null           $user
	 *
	 * @return Response
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function create(AlbumDTO $albumDTO, FileUploaderService $uploadedFileService, ?User $user): Response
	{

		/** @var Response|Album $createdEntity */
		$createdEntity = $this->make($albumDTO);

		if ($createdEntity instanceof Response) {
			return $createdEntity;
		}

		$createdEntity->setPhoto($this->uploadPhoto($uploadedFileService, $user));

		return $this->manager->push($createdEntity, 'album@successCreate');

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