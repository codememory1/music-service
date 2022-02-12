<?php

namespace App\Service\Album\Category;

use App\DTO\AlbumCategoryDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\UpdaterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterAlbumCategoryService
 *
 * @package App\Service\Album\Category
 *
 * @author  Codememory
 */
class UpdaterAlbumCategoryService extends UpdaterCRUDService
{

    /**
     * @param AlbumCategoryDTO   $albumCategoryDTO
     * @param ValidatorInterface $validator
     * @param int                $id
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function update(AlbumCategoryDTO $albumCategoryDTO, ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;
        $this->messageNameNotExist = 'album_category_not_exist';
        $this->translationKeyNotExist = 'albumCategory@notExist';

        $updatedEntity = $this->make($albumCategoryDTO, ['id' => $id]);

        if ($updatedEntity instanceof ApiResponseService) {
            return $updatedEntity;
        }

        return $this->push($updatedEntity, 'albumCategory@successUpdate', true);

    }

}