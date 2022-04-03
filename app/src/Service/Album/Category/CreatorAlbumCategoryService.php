<?php

namespace App\Service\Album\Category;

use App\DTO\AlbumCategoryDTO;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorAlbumCategoryService.
 *
 * @package App\Service\Album\Category
 *
 * @author  Codememory
 */
class CreatorAlbumCategoryService extends CreatorCRUD
{
    /**
     * @param AlbumCategoryDTO $albumCategoryDTO
     *
     * @return Response
     */
    public function create(AlbumCategoryDTO $albumCategoryDTO): Response
    {
        $this->validateEntity = true;

        $createdEntity = $this->make($albumCategoryDTO);

        if ($createdEntity instanceof Response) {
            return $createdEntity;
        }

        return $this->manager->push($createdEntity, 'albumCategory@successCreate');
    }
}