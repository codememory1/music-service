<?php

namespace App\Service\UserRole;

use App\Entity\Role;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserRoleService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {
    }

    public function delete(Role $role): Role
    {
        $this->flusherService->remove($role);

        return $role;
    }

    public function request(Role $role): JsonResponse
    {
        $this->delete($role);

        return $this->responseCollection->successDelete('role@successDelete');
    }
}