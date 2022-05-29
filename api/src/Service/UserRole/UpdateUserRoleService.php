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
        if (false === $this->validate($userRoleDTO)) {
            return $this->validator->getResponse();
        }

        $roleEntity = $userRoleDTO->getEntity();

        if (false === $this->validate($roleEntity)) {
            return $this->validator->getResponse();
        }

        $this->em->flush();

        return $this->responseCollection->successCreate('role@successUpdate');
    }
}