<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Dto\SubscriptionDto;
use App\Entity\Subscription;
use App\Service\Subscription\CreatorSubscriptionService;
use App\Service\Subscription\DeleterSubscriptionService;
use App\Service\Subscription\UpdaterSubscriptionService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

        return $this->showAllFromDatabase(Subscription::class, SubscriptionDto::class);

    }

    /**
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/subscription/create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {

        return $this->executeCreateService(
            CreatorSubscriptionService::class,
            'subscription@successCreate',
            $request,
            $validator
        );

    }

    /**
     * @param int                $id
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/subscription/{id<\d+>}/edit', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {

        return $this->executeUpdateService(
            $id,
            UpdaterSubscriptionService::class,
            'subscription@successUpdate',
            $request,
            $validator
        );

    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/subscription/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(int $id, Request $request): JsonResponse
    {

        return $this->executeDeleteService(
            $id,
            DeleterSubscriptionService::class,
            'subscription@successDelete',
            $request
        );

    }

}