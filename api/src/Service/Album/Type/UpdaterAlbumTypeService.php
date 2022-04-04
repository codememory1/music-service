<?php

namespace App\Service\Album\Type;

use App\DTO\AlbumTypeDTO;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterAlbumTypeService.
 *
 * @package App\Service\Album\Type
 *
 * @author  Codememory
 */
class UpdaterAlbumTypeService extends UpdaterCRUD
{
    /**
     * @param AlbumTypeDTO $albumTypeDTO
     * @param int          $id
     *
     * @return Response
     */
    public function update(AlbumTypeDTO $albumTypeDTO, int $id): Response
    {
        $this->validateEntity = true;
        $this->translationKeyNotExist = 'albumType@notExist';

        $updatedEntity = $this->make($albumTypeDTO, ['id' => $id]);

        if ($updatedEntity instanceof Response) {
            return $updatedEntity;
        }

        return $this->manager->update($updatedEntity, 'albumType@successUpdate');
    }
}