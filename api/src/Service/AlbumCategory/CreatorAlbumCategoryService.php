<?php

namespace App\Service\AlbumCategory;

use App\DTO\AlbumCategoryDTO;
use App\Entity\AlbumCategory;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorAlbumCategoryService.
 *
 * @package App\Service\AlbumCategory
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

        /** @var AlbumCategory|Response $createdAlbumCategory */
        $createdAlbumCategory = $this->make($albumCategoryDTO);

        if ($createdAlbumCategory instanceof Response) {
            return $createdAlbumCategory;
        }

        return $this->manager->push($createdAlbumCategory, 'albumCategory@successCreate');
    }
}