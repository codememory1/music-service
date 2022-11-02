<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Entity\RolePermission;
use App\Entity\RolePermissionKey;
use App\Enum\RoleEnum;
use App\Enum\RolePermissionEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class RolePermissionFactory implements DataFixtureFactoryInterface
{
    private ?ReferenceRepository $referenceRepository = null;

    public function __construct(
        private readonly RoleEnum $roleKey,
        private readonly RolePermissionEnum $rolePermissionKey
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        /** @var Role $role */
        $role = $this->referenceRepository->getReference("r-{$this->roleKey}");

        /** @var RolePermissionKey $rolePermissionKey */
        $rolePermissionKey = $this->referenceRepository->getReference("rpk-{$this->rolePermissionKey->name}");
        $rolePermission = new RolePermission();

        $rolePermission->setRole($role);
        $rolePermission->setPermissionKey($rolePermissionKey);

        return $rolePermission;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}