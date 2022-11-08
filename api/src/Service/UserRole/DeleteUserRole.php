<?php

namespace App\Service\UserRole;

use App\Entity\Role;
use App\Service\FlusherService;

final class DeleteUserRole
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(Role $role): Role
    {
        $this->flusher->remove($role);

        return $role;
    }
}