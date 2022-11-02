<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\RolePermissionKey;
use App\Enum\RolePermissionEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class RolePermissionKeyFactory implements DataFixtureFactoryInterface
{
    public function __construct(
        private readonly RolePermissionEnum $rolePermission,
        private readonly string $titleTranslationKey
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        $rolePermissionKey = new RolePermissionKey();

        $rolePermissionKey->setKey($this->rolePermission);
        $rolePermissionKey->setTitle($this->titleTranslationKey);

        return $rolePermissionKey;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}