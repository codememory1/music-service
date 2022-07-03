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

    public function make(Album $album): JsonResponse
    {
        $this->imageUploader->delete($album->getImage());

        $this->em->remove($album);
        $this->em->flush();

        return $this->responseCollection->successDelete('album@successDelete');
    }
}