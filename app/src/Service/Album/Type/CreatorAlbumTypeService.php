<?php

namespace App\Service\Album\Type;

use App\DTO\AlbumTypeDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\CreatorCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorAlbumTypeService
 *
 * @package App\Service\Album\Type
 *
 * @author  Codememory
 */
class CreatorAlbumTypeService extends CreatorCRUDService
{

    /**
     * @param AlbumTypeDTO       $albumTypeDTO
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function create(AlbumTypeDTO $albumTypeDTO, ValidatorInterface $validator): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;

        $createdEntity = $this->make($albumTypeDTO);

        if ($createdEntity instanceof ApiResponseService) {
            return $createdEntity;
        }

        return $this->push($createdEntity, 'albumType@successCreate');

    }

}