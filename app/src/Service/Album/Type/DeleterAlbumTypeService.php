<?php

namespace App\Service\Album\Type;

use App\Entity\AlbumType;
use App\Service\CRUD\DeleterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DeleterAlbumTypeService
 *
 * @package App\Service\Album\Type
 *
 * @author  Codememory
 */
class DeleterAlbumTypeService extends DeleterCRUDService
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
        $this->messageNameNotExist = 'album_type_not_exist';
        $this->translationKeyNotExist = 'albumType@notExist';

        $deletedEntity = $this->make(AlbumType::class, ['id' => $id]);

        if ($deletedEntity instanceof ApiResponseService) {
            return $deletedEntity;
        }

        return $this->remove($deletedEntity, 'albumType@successDelete');

    }

}