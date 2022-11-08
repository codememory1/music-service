<?php

namespace App\Service\UserRole;

use App\Dto\Transfer\UserRoleDto;
use App\Entity\Role;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

final class UpdateUserRole
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function update(UserRoleDto $dto): Role
    {
        $this->validator->validate($dto);

        $role = $dto->getEntity();

        $this->validator->validate($role);

        $this->flusher->save();

        return $role;
    }
}