<?php

namespace App\Service\Album;

use App\Entity\Album;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class DeleteAlbumService.
 *
 * @package App\Service\Album
 *
 * @author  Codememory
 */
class DeleteAlbumService extends AbstractService
{
    #[Required]
    public ?ImageUploader $imageUploader = null;

    public function delete(Album $album): Album
    {
        $this->imageUploader->delete($album->getImage());

        $this->flusherService->remove($album);

        return $album;
    }

    public function request(Album $album): JsonResponse
    {
        $this->delete($album);

        return $this->responseCollection->successDelete('album@successDelete');
    }
}