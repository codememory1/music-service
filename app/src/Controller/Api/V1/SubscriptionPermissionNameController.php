<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Dto\SubscriptionPermissionNameDto;
use App\Entity\SubscriptionPermissionName;
use App\Service\Subscription\Permission\Name\CreatorPermissionNameService;
use App\Service\Subscription\Permission\Name\DeleterPermissionNameService;
use App\Service\Subscription\Permission\Name\UpdaterPermissionNameService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
            SubscriptionPermissionNameDto::class
        );

    }

    /**
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/subscription/permission-name/create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {

        return $this->executeCreateService(
            CreatorPermissionNameService::class,
            'subscriptionPermissionName@successCreate',
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
    #[Route('/subscription/permission-name/{id<\d+>}/edit', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {

        return $this->executeUpdateService(
            $id,
            UpdaterPermissionNameService::class,
            'subscriptionPermissionName@successUpdate',
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
    #[Route('/subscription/permission-name/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(int $id, Request $request): JsonResponse
    {

        return $this->executeDeleteService(
            $id,
            DeleterPermissionNameService::class,
            'subscriptionPermissionName@successDelete',
            $request
        );

    }

}