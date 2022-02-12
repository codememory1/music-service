<?php

namespace App\Service\Album\Category;

use App\DTO\AlbumCategoryDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\CRUD\CreatorCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreatorAlbumCategoryService
 *
 * @package App\Service\Album\Category
 *
 * @author  Codememory
 */
class CreatorAlbumCategoryService extends CreatorCRUDService
{

    /**
     * @param AlbumCategoryDTO   $albumCategoryDTO
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws UndefinedClassForDTOException
     * @throws Exception
     */
    public function create(AlbumCategoryDTO $albumCategoryDTO, ValidatorInterface $validator): ApiResponseService
    {

        $this->validator = $validator;
        $this->validateEntity = true;

        $createdEntity = $this->make($albumCategoryDTO);

        if ($createdEntity instanceof ApiResponseService) {
            return $createdEntity;
        }

        return $this->push($createdEntity, 'albumCategory@successCreate');

    }

}