<?php

namespace App\Service\UserRole;

use App\Entity\Role;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteUserRole
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function delete(Role $role): Role
    {
        $this->flusher->remove($role);

        return $role;
    }
}