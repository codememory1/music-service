<?php

namespace App\Service\AlbumType;

use App\DTO\AlbumTypeDTO;
use App\Entity\AlbumCategory;
use App\Rest\CRUD\CreatorCRUD;
use App\Rest\Http\Response;

/**
 * Class CreatorAlbumTypeService.
 *
 * @package App\Service\AlbumType
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

        /** @var AlbumCategory|Response $createdAlbumType */
        $createdAlbumType = $this->make($albumTypeDTO);

        if ($createdAlbumType instanceof Response) {
            return $createdAlbumType;
        }

        return $this->manager->push($createdAlbumType, 'albumType@successCreate');
    }
}