<?php

namespace App\Service\Album;

use App\Entity\Album;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterAlbumService
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class DeleterAlbumService extends DeleterCRUD
{

	/**
	 * @param string $kernelProjectDir
	 * @param int    $id
	 *
	 * @return Response
	 * @throws Exception
	 */
	public function delete(string $kernelProjectDir, int $id): Response
	{

		$this->translationKeyNotExist = 'album@notExist';

		/** @var Response|Album $deletedEntity */
		$deletedEntity = $this->make(Album::class, ['id' => $id]);

		if ($deletedEntity instanceof Response) {
			return $deletedEntity;
		}

		$this->deletePhoto($deletedEntity, $kernelProjectDir);

		return $this->manager->remove($deletedEntity, 'album@successDelete');

	}

	/**
	 * @param Album  $album
	 * @param string $kernelProjectDir
	 *
	 * @return void
	 */
	private function deletePhoto(Album $album, string $kernelProjectDir): void
	{

		$absolutePathPhoto = sprintf('%s/%s', $kernelProjectDir, $album->getPhoto());

		if (file_exists($absolutePathPhoto)) {
			unlink($absolutePathPhoto);
		}

	}

}