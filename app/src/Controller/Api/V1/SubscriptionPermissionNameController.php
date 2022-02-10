<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\DTO\SubscriptionPermissionNameDTO;
use App\Entity\SubscriptionPermissionName;
use App\Exception\UndefinedClassForDTOException;
use App\Service\RequestDataService;
use App\Service\Subscription\Permission\Name\CreatorPermissionNameService;
use App\Service\Subscription\Permission\Name\DeleterPermissionNameService;
use App\Service\Subscription\Permission\Name\UpdaterPermissionNameService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionPermissionNameController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class SubscriptionPermissionNameController extends AbstractApiController
{

    /**
     * @return JsonResponse
     */
    #[Route('/subscription/permission-names', methods: 'GET')]
    public function all(): JsonResponse
    {

        return $this->showAllFromDatabase(
            SubscriptionPermissionName::class,
            SubscriptionPermissionNameDTO::class
        );

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/subscription/permission-name/create', methods: 'POST')]
    public function create(Request $request, RequestDataService $requestDataService): JsonResponse
    {

        /** @var CreatorPermissionNameService $service */
        $service = $this->getCollectedService($request, CreatorPermissionNameService::class);
        $subscriptionPermissionNameDTO = new SubscriptionPermissionNameDTO($requestDataService, $this->managerRegistry);

        return $service->create($subscriptionPermissionNameDTO, $this->validator)->make();

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     * @param int                $id
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/subscription/permission-name/{id<\d+>}/edit', methods: 'PUT')]
    public function update(Request $request, RequestDataService $requestDataService, int $id): JsonResponse
    {

        /** @var UpdaterPermissionNameService $service */
        $service = $this->getCollectedService($request, UpdaterPermissionNameService::class);
        $subscriptionPermissionNameDTO = new SubscriptionPermissionNameDTO($requestDataService, $this->managerRegistry);

        return $service->update($subscriptionPermissionNameDTO, $this->validator, $id)->make();

    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/subscription/permission-name/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(int $id, Request $request): JsonResponse
    {

        /** @var DeleterPermissionNameService $service */
        $service = $this->getCollectedService($request, DeleterPermissionNameService::class);

        return $service->delete($id)->make();

    }

}