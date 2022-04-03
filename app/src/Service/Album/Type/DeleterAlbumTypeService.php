<?php

namespace App\Service\Album\Type;

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

        $deletedEntity = $this->make(AlbumType::class, ['id' => $id]);

        if ($deletedEntity instanceof Response) {
            return $deletedEntity;
        }

        return $this->manager->remove($deletedEntity, 'albumType@successDelete');
    }
}