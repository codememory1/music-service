<?php

namespace App\Service\Album;

use App\Entity\Album;
use App\Service\CRUD\DeleterCRUDService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DeleterAlbumService
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class DeleterAlbumService extends DeleterCRUDService
{

    /**
     * @param ValidatorInterface $validator
     * @param string             $kernelProjectDir
     * @param int                $id
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function delete(ValidatorInterface $validator, string $kernelProjectDir, int $id): ApiResponseService
    {

        $this->validator = $validator;
        $this->messageNameNotExist = 'album_not_exist';
        $this->translationKeyNotExist = 'album@notExist';

        /** @var ApiResponseService|Album $deletedEntity */
        $deletedEntity = $this->make(Album::class, ['id' => $id]);

        if ($deletedEntity instanceof ApiResponseService) {
            return $deletedEntity;
        }

        $this->deletePhoto($deletedEntity, $kernelProjectDir);

        return $this->remove($deletedEntity, 'album@successDelete');

    }

    /**
     * @param Album  $album
     * @param string $kernelProjectDir
     *
     * @return void
     */
    private function deletePhoto(Album $album, string $kernelProjectDir): void
    {

        $absolutePathPhoto = sprintf('%s/%s', $kernelProjectDir, $album->getPhoto());

        if (file_exists($absolutePathPhoto)) {
            unlink($absolutePathPhoto);
        }

    }

}