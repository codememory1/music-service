<?php

namespace App\Service\AlbumType;

use App\DTO\AlbumTypeDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreateAlbumTypeService.
 *
 * @package App\Service\AlbumType
 *
 * @author  Codememory
 */
class CreateAlbumTypeService extends AbstractService
{
    /**
     * @param AlbumTypeDTO $albumTypeDTO
     *
     * @return JsonResponse
     */
    public function make(AlbumTypeDTO $albumTypeDTO): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($albumTypeDTO)) {
            return $response;
        }

        $this->em->persist($albumTypeDTO->getEntity());
        $this->em->flush();

        return $this->responseCollection->successCreate('albumType@successCreate');
    }
}