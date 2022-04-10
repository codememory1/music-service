<?php

namespace App\Service\Album;

use App\Entity\Album;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use App\Rest\S3\Uploader\ImageUploader;
use Exception;

/**
 * Class DeleterAlbumService.
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class DeleterAlbumService extends DeleterCRUD
{
    /**
     * @param string $kernelProjectDir
     * @param int    $id
     *
     * @throws Exception
     *
     * @return Response
     */
    public function delete(ImageUploader $imageUploader, int $id): Response
    {
        $this->translationKeyNotExist = 'album@notExist';

        /** @var Album|Response $deletedAlbum */
        $deletedAlbum = $this->make(Album::class, ['id' => $id]);

        if ($deletedAlbum instanceof Response) {
            return $deletedAlbum;
        }

        $imageUploader->delete($deletedAlbum->getPhoto());

        return $this->manager->remove($deletedAlbum, 'album@successDelete');
    }
}