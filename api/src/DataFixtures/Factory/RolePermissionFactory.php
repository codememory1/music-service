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

/**
 * Class RolePermissionFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class RolePermissionFactory implements DataFixtureFactoryInterface
{
    /**
     * @var string
     */
    private string $roleKey;

    /**
     * @var string
     */
    private string $rolePermissionKey;

    /**
     * @var ReferenceRepository
     */
    private ReferenceRepository $referenceRepository;

    /**
     * @param string $roleKey
     * @param string $rolePermissionKey
     */
    public function __construct(RoleEnum $roleKey, RolePermissionEnum $rolePermissionKey)
    {
        $this->roleKey = $roleKey->name;
        $this->rolePermissionKey = $rolePermissionKey->name;
    }

    /**
     * @inheritDoc
     */
    public function factoryMethod(): EntityInterface
    {
        /** @var Role $role */
        $role = $this->referenceRepository->getReference("r-{$this->roleKey}");

        /** @var RolePermissionKey $rolePermissionKey */
        $rolePermissionKey = $this->referenceRepository->getReference("rpk-{$this->rolePermissionKey}");
        $rolePermissionEntity = new RolePermission();

        $rolePermissionEntity->setRole($role);
        $rolePermissionEntity->setPermission($rolePermissionKey);

        return $rolePermissionEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}