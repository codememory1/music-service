<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Dto\SubscriptionPermissionDto;
use App\Entity\SubscriptionPermission;
use App\Service\Subscription\Permission\CreatorPermissionService;
use App\Service\Subscription\Permission\DeleterPermissionService;
use App\Service\Subscription\Permission\UpdaterPermissionService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
            SubscriptionPermissionDto::class
        );

    }

    /**
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/subscription/permission/create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {

        return $this->executeCreateService(
            CreatorPermissionService::class,
            'subscriptionPermission@successCreate',
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
    #[Route('/subscription/permission/{id<\d+>}/edit', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {

        return $this->executeUpdateService(
            $id,
            UpdaterPermissionService::class,
            'subscriptionPermission@successUpdate',
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
    #[Route('/subscription/permission/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(int $id, Request $request): JsonResponse
    {

        return $this->executeDeleteService(
            $id,
            DeleterPermissionService::class,
            'subscriptionPermission@successDelete',
            $request
        );

    }

}