<?php

namespace App\Service\UserRole;

use App\Dto\Transfer\UserRoleDto;
use App\Entity\Role;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

final class CreateUserRole
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function create(UserRoleDto $dto): Role
    {
        $this->validator->validate($dto);

        $role = $dto->getEntity();

        $this->validator->validate($role);

        $this->flusher->save($role);

        return $role;
    }
}