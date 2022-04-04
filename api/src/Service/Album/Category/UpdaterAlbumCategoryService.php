<?php

namespace App\Service\Album\Category;

use App\DTO\AlbumCategoryDTO;
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

        $updatedEntity = $this->make($albumCategoryDTO, ['id' => $id]);

        if ($updatedEntity instanceof Response) {
            return $updatedEntity;
        }

        return $this->manager->update($updatedEntity, 'albumCategory@successUpdate');
    }
}