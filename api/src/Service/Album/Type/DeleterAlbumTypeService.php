<?php

namespace App\Service\Album\Type;

use App\Entity\AlbumCategory;
use App\Entity\AlbumType;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterAlbumTypeService.
 *
 * @package App\Service\Album\Type
 *
 * @author  Codememory
 */
class DeleterAlbumTypeService extends DeleterCRUD
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
        $this->translationKeyNotExist = 'albumType@notExist';

        /** @var AlbumCategory|Response $deletedAlbumType */
        $deletedAlbumType = $this->make(AlbumType::class, ['id' => $id]);

        if ($deletedAlbumType instanceof Response) {
            return $deletedAlbumType;
        }

        return $this->manager->remove($deletedAlbumType, 'albumType@successDelete');
    }
}