<?php

namespace App\Service\Album\Type;

use App\DTO\AlbumTypeDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\UpdaterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterAlbumTypeService
 *
 * @package App\Service\Album\Type
 *
 * @author  Codememory
 */
class UpdaterAlbumTypeService extends UpdaterCRUDService
{

    /**
     * @param AlbumTypeDTO       $albumTypeDTO
     * @param ValidatorInterface $validator
     * @param int                $id
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function update(AlbumTypeDTO $albumTypeDTO, ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;
        $this->messageNameNotExist = 'album_type_not_exist';
        $this->translationKeyNotExist = 'albumType@notExist';

        $updatedEntity = $this->make($albumTypeDTO, ['id' => $id]);

        if ($updatedEntity instanceof ApiResponseService) {
            return $updatedEntity;
        }

        return $this->push($updatedEntity, 'albumType@successUpdate');

    }

}