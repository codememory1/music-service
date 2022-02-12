<?php

namespace App\Service\Album\Category;

use App\Entity\AlbumCategory;
use App\Service\CRUD\DeleterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DeleterAlbumCategoryService
 *
 * @package App\Service\Album\Category
 *
 * @author  Codememory
 */
class DeleterAlbumCategoryService extends DeleterCRUDService
{

    /**
     * @param ValidatorInterface $validator
     * @param int                $id
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function delete(ValidatorInterface $validator, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->messageNameNotExist = 'album_category_not_exist';
        $this->translationKeyNotExist = 'albumCategory@notExist';

        $deletedEntity = $this->make(AlbumCategory::class, ['id' => $id]);

        if ($deletedEntity instanceof ApiResponseService) {
            return $deletedEntity;
        }

        return $this->remove($deletedEntity, 'albumCategory@successDelete');

    }

}