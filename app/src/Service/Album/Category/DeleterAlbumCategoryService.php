<?php

namespace App\Service\Album\Category;

use App\Entity\AlbumCategory;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterAlbumCategoryService
 *
 * @package App\Service\Album\Category
 *
 * @author  Codememory
 */
class DeleterAlbumCategoryService extends DeleterCRUD
{

	/**
	 * @param int $id
	 *
	 * @return Response
	 * @throws Exception
	 */
	public function delete(int $id): Response
	{

		$this->translationKeyNotExist = 'albumCategory@notExist';

		$deletedEntity = $this->make(AlbumCategory::class, ['id' => $id]);

		if ($deletedEntity instanceof Response) {
			return $deletedEntity;
		}

		return $this->manager->remove($deletedEntity, 'albumCategory@successDelete');

	}

}