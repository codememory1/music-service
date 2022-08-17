<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\RolePermissionKey;
use App\Enum\RolePermissionEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class RolePermissionKeyFactory implements DataFixtureFactoryInterface
{
    private RolePermissionEnum $rolePermission;
    private string $titleTranslationKey;

    public function __construct(RolePermissionEnum $rolePermission, string $titleTranslationKey)
    {
        $this->rolePermission = $rolePermission;
        $this->titleTranslationKey = $titleTranslationKey;
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