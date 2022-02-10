<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\DTO\SubscriptionDTO;
use App\Entity\Subscription;
use App\Exception\UndefinedClassForDTOException;
use App\Service\RequestDataService;
use App\Service\Subscription\CreatorSubscriptionService;
use App\Service\Subscription\DeleterSubscriptionService;
use App\Service\Subscription\UpdaterSubscriptionService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class SubscriptionController extends AbstractApiController
{

    /**
     * @return JsonResponse
     */
    #[Route('/subscriptions', methods: 'GET')]
    public function all(): JsonResponse
    {

        return $this->showAllFromDatabase(Subscription::class, SubscriptionDTO::class);

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/subscription/create', methods: 'POST')]
    public function create(Request $request, RequestDataService $requestDataService): JsonResponse
    {

        /** @var CreatorSubscriptionService $service */
        $service = $this->getCollectedService($request, CreatorSubscriptionService::class);
        $subscriptionDTO = new SubscriptionDTO($requestDataService, $this->managerRegistry);

        return $service->create($subscriptionDTO, $this->validator)->make();

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     * @param int                $id
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/subscription/{id<\d+>}/edit', methods: 'PUT')]
    public function update(Request $request, RequestDataService $requestDataService, int $id): JsonResponse
    {

        /** @var UpdaterSubscriptionService $service */
        $service = $this->getCollectedService($request, UpdaterSubscriptionService::class);
        $subscriptionDTO = new SubscriptionDTO($requestDataService, $this->managerRegistry);

        return $service->update($subscriptionDTO, $this->validator, $id)->make();

    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/subscription/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(Request $request, int $id): JsonResponse
    {

        /** @var DeleterSubscriptionService $service */
        $service = $this->getCollectedService($request, DeleterSubscriptionService::class);

        return $service->delete($id)->make();

    }

}