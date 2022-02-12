<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\DTO\AlbumTypeDTO;
use App\Entity\AlbumType;
use App\Exception\UndefinedClassForDTOException;
use App\Service\Album\Type\CreatorAlbumTypeService;
use App\Service\Album\Type\DeleterAlbumTypeService;
use App\Service\Album\Type\UpdaterAlbumTypeService;
use App\Service\RequestDataService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumTypeController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class AlbumTypeController extends AbstractApiController
{

    /**
     * @return JsonResponse
     */
    #[Route('/album/types', methods: 'GET')]
    public function all(): JsonResponse
    {

        return $this->showAllFromDatabase(
            AlbumType::class,
            AlbumTypeDTO::class
        );

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/album/type/create', methods: 'POST')]
    public function create(Request $request, RequestDataService $requestDataService): JsonResponse
    {

        /** @var CreatorAlbumTypeService $service */
        $service = $this->getCollectedService($request, CreatorAlbumTypeService::class);
        $albumTypeDTO = new AlbumTypeDTO($requestDataService, $this->managerRegistry);

        return $service->create($albumTypeDTO, $this->validator)->make();

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     * @param int                $id
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/album/type/{id<\d+>}/edit', methods: 'PUT')]
    public function update(Request $request, RequestDataService $requestDataService, int $id): JsonResponse
    {

        /** @var UpdaterAlbumTypeService $service */
        $service = $this->getCollectedService($request, UpdaterAlbumTypeService::class);
        $albumTypeDTO = new AlbumTypeDTO($requestDataService, $this->managerRegistry);

        return $service->update($albumTypeDTO, $this->validator, $id)->make();

    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/album/type/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(Request $request, int $id): JsonResponse
    {

        /** @var DeleterAlbumTypeService $service */
        $service = $this->getCollectedService($request, DeleterAlbumTypeService::class);

        return $service->delete($this->validator, $id)->make();

    }

}