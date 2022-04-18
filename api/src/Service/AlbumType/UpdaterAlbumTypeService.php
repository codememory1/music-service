<?php

namespace App\Service\AlbumType;

use App\DTO\AlbumTypeDTO;
use App\Entity\AlbumCategory;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterAlbumTypeService.
 *
 * @package App\Service\AlbumType
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

        /** @var AlbumCategory|Response $updatedAlbumType */
        $updatedAlbumType = $this->make($albumTypeDTO, ['id' => $id]);

        if ($updatedAlbumType instanceof Response) {
            return $updatedAlbumType;
        }

        return $this->manager->update($updatedAlbumType, 'albumType@successUpdate');
    }
}