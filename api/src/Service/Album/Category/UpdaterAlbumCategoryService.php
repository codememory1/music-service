<?php

namespace App\Service\Album\Category;

use App\DTO\AlbumCategoryDTO;
use App\Entity\AlbumCategory;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterAlbumCategoryService.
 *
 * @package App\Service\Album\Category
 *
 * @author  Codememory
 */
class UpdaterAlbumCategoryService extends UpdaterCRUD
{
    /**
     * @param AlbumCategoryDTO $albumCategoryDTO
     * @param int              $id
     *
     * @return Response
     */
    public function update(AlbumCategoryDTO $albumCategoryDTO, int $id): Response
    {
        $this->validateEntity = true;
        $this->translationKeyNotExist = 'albumCategory@notExist';

        /** @var AlbumCategory|Response $updatedAlbumCategory */
        $updatedAlbumCategory = $this->make($albumCategoryDTO, ['id' => $id]);

        if ($updatedAlbumCategory instanceof Response) {
            return $updatedAlbumCategory;
        }

        return $this->manager->update($updatedAlbumCategory, 'albumCategory@successUpdate');
    }
}