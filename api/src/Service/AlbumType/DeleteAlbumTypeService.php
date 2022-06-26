<?php

namespace App\Service\AlbumType;

use App\Entity\AlbumType;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteAlbumTypeService.
 *
 * @package App\Service\AlbumType
 *
 * @author  Codememory
 */
class DeleteAlbumTypeService extends AbstractService
{
    /**
     * @param AlbumType $albumType
     *
     * @return JsonResponse
     */
    public function make(AlbumType $albumType): JsonResponse
    {
        $this->em->remove($albumType);
        $this->em->flush();

        return $this->responseCollection->successDelete('albumType@successDelete');
    }
}