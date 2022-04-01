<?php

namespace App\Service\Album\Type;

use App\DTO\AlbumTypeDTO;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorAlbumTypeService
 *
 * @package App\Service\Album\Type
 *
 * @author  Codememory
 */
class CreatorAlbumTypeService extends CreatorCRUD
{

	/**
	 * @param AlbumTypeDTO $albumTypeDTO
	 *
	 * @return Response
	 */
	public function create(AlbumTypeDTO $albumTypeDTO): Response
	{

		$this->validateEntity = true;

		$createdEntity = $this->make($albumTypeDTO);

		if ($createdEntity instanceof Response) {
			return $createdEntity;
		}

		return $this->manager->push($createdEntity, 'albumType@successCreate');

	}

}