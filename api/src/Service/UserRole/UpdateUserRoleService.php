<?php

namespace App\Service\UserRole;

use App\DTO\UserRoleDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateUserRoleService.
 *
 * @package App\Service\UserRole
 *
 * @author  Codememory
 */
class UpdateUserRoleService extends AbstractService
{
    /**
     * @param UserRoleDTO $userRoleDTO
     *
     * @return JsonResponse
     */
    public function make(UserRoleDTO $userRoleDTO): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($userRoleDTO)) {
            return $response;
        }

        $this->em->flush();

        return $this->responseCollection->successCreate('role@successUpdate');
    }
}