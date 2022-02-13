<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Exception\UndefinedClassForDTOException;
use App\Security\TokenAuthenticator;
use App\Service\Album\CreatorAlbumService;
use App\Service\Album\DeleterAlbumService;
use App\Service\Album\UpdaterAlbumService;
use App\Service\FileUploaderService;
use App\Service\RequestDataService;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class AlbumController extends AbstractApiController
{

    /**
     * @return JsonResponse
     */
    #[Route('/albums', methods: 'GET')]
    public function all(): JsonResponse
    {

        return $this->showAllFromDatabase(
            Album::class,
            AlbumDTO::class
        );

    }

    /**
     * @param Request             $request
     * @param RequestDataService  $requestDataService
     * @param FileUploaderService $fileUploaderService
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/album/create', methods: 'POST')]
    public function create(Request $request, RequestDataService $requestDataService, FileUploaderService $fileUploaderService): JsonResponse
    {

        $fileUploaderService
            ->initRequestFile('photo')
            ->setSaveTo('public/uploads/album');

        /** @var CreatorAlbumService $service */
        $service = $this->getCollectedService($request, CreatorAlbumService::class);
        $albumDTO = new AlbumDTO($requestDataService, $this->managerRegistry);
        $user = (new TokenAuthenticator($request, $this->managerRegistry))->getUser();

        $albumDTO->setPhoto($fileUploaderService->getInitializedRequestFile());

        return $service->create($albumDTO, $this->validator, $fileUploaderService, $user)->make();

    }

    /**
     * @param Request             $request
     * @param RequestDataService  $requestDataService
     * @param FileUploaderService $fileUploaderService
     * @param int                 $id
     *
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws UndefinedClassForDTOException
     */
    #[Route('/album/{id<\d+>}/edit', methods: 'POST')]
    public function update(Request $request, RequestDataService $requestDataService, FileUploaderService $fileUploaderService, int $id): JsonResponse
    {

        $fileUploaderService
            ->initRequestFile('photo')
            ->setSaveTo('public/uploads/album');

        /** @var UpdaterAlbumService $service */
        $service = $this->getCollectedService($request, UpdaterAlbumService::class);
        $albumDTO = new AlbumDTO($requestDataService, $this->managerRegistry);
        $user = (new TokenAuthenticator($request, $this->managerRegistry))->getUser();

        $albumDTO->setPhoto($fileUploaderService->getInitializedRequestFile());

        return $service->update(
            $albumDTO,
            $this->validator,
            $fileUploaderService,
            $user,
            $this->getParameter('kernel.project_dir'),
            $id
        )->make();

    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/album/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(Request $request, int $id): JsonResponse
    {

        /** @var DeleterAlbumService $service */
        $service = $this->getCollectedService($request, DeleterAlbumService::class);

        return $service->delete(
            $this->validator,
            $this->getParameter('kernel.project_dir'),
            $id
        )->make();

    }

}