<?php

namespace App\Service\AlbumCategory;

use App\Entity\AlbumCategory;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterAlbumCategoryService.
 *
 * @package App\Service\AlbumCategory
 *
 * @author  Codememory
 */
class DeleterAlbumCategoryService extends DeleterCRUD
{
    /**
     * @param int $id
     *
     * @throws Exception
     *
     * @return Response
     */
    public function delete(int $id): Response
    {
        $this->translationKeyNotExist = 'albumCategory@notExist';

        /** @var AlbumCategory|Response $deletedAlbumCategory */
        $deletedAlbumCategory = $this->make(AlbumCategory::class, ['id' => $id]);

        if ($deletedAlbumCategory instanceof Response) {
            return $deletedAlbumCategory;
        }

        return $this->manager->remove($deletedAlbumCategory, 'albumCategory@successDelete');
    }
}