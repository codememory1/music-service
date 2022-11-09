<?php

namespace App\Service\UserRole;

use App\Dto\Transfer\UserRoleDto;
use App\Entity\Role;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class UpdateUserRole
{
    public function __construct(
        private readonly Flusher $flusher,
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