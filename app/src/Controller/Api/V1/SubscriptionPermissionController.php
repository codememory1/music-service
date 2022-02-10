<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\DTO\SubscriptionPermissionDTO;
use App\Entity\SubscriptionPermission;
use App\Exception\UndefinedClassForDTOException;
use App\Service\RequestDataService;
use App\Service\Subscription\Permission\CreatorPermissionService;
use App\Service\Subscription\Permission\DeleterPermissionService;
use App\Service\Subscription\Permission\UpdaterPermissionService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionPermissionController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class SubscriptionPermissionController extends AbstractApiController
{

    /**
     * @return JsonResponse
     */
    #[Route('/subscription/permissions', methods: 'GET')]
    public function all(): JsonResponse
    {

        return $this->showAllFromDatabase(
            SubscriptionPermission::class,
            SubscriptionPermissionDTO::class
        );

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/subscription/permission/create', methods: 'POST')]
    public function create(Request $request, RequestDataService $requestDataService): JsonResponse
    {

        /** @var CreatorPermissionService $service */
        $service = $this->getCollectedService($request, CreatorPermissionService::class);
        $subscriptionPermissionDTO = new SubscriptionPermissionDTO($requestDataService, $this->managerRegistry);

        return $service->create($subscriptionPermissionDTO, $this->validator)->make();

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     * @param int                $id
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/subscription/permission/{id<\d+>}/edit', methods: 'PUT')]
    public function update(Request $request, RequestDataService $requestDataService, int $id): JsonResponse
    {

        /** @var UpdaterPermissionService $service */
        $service = $this->getCollectedService($request, UpdaterPermissionService::class);
        $subscriptionPermissionDTO = new SubscriptionPermissionDTO($requestDataService, $this->managerRegistry);

        return $service->update($subscriptionPermissionDTO, $this->validator, $id)->make();

    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/subscription/permission/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(Request $request, int $id): JsonResponse
    {

        /** @var DeleterPermissionService $service */
        $service = $this->getCollectedService($request, DeleterPermissionService::class);

        return $service->delete($id)->make();

    }

}