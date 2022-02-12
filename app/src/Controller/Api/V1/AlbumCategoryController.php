<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\DTO\AlbumCategoryDTO;
use App\Entity\AlbumCategory;
use App\Exception\UndefinedClassForDTOException;
use App\Service\Album\Category\CreatorAlbumCategoryService;
use App\Service\Album\Category\DeleterAlbumCategoryService;
use App\Service\Album\Category\UpdaterAlbumCategoryService;
use App\Service\RequestDataService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumCategoryController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class AlbumCategoryController extends AbstractApiController
{

    /**
     * @return JsonResponse
     */
    #[Route('/album/categories', methods: 'GET')]
    public function all(): JsonResponse
    {

        return $this->showAllFromDatabase(
            AlbumCategory::class,
            AlbumCategoryDTO::class
        );

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/album/category/create', methods: 'POST')]
    public function create(Request $request, RequestDataService $requestDataService): JsonResponse
    {

        /** @var CreatorAlbumCategoryService $service */
        $service = $this->getCollectedService($request, CreatorAlbumCategoryService::class);
        $albumCategoryDTO = new AlbumCategoryDTO($requestDataService, $this->managerRegistry);

        return $service->create($albumCategoryDTO, $this->validator)->make();

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     * @param int                $id
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/album/category/{id<\d+>}/edit', methods: 'PUT')]
    public function update(Request $request, RequestDataService $requestDataService, int $id): JsonResponse
    {

        /** @var UpdaterAlbumCategoryService $service */
        $service = $this->getCollectedService($request, UpdaterAlbumCategoryService::class);
        $albumCategoryDTO = new AlbumCategoryDTO($requestDataService, $this->managerRegistry);

        return $service->update($albumCategoryDTO, $this->validator, $id)->make();

    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/album/category/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(Request $request, int $id): JsonResponse
    {

        /** @var DeleterAlbumCategoryService $service */
        $service = $this->getCollectedService($request, DeleterAlbumCategoryService::class);

        return $service->delete($this->validator, $id)->make();

    }

}