<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\RolePermissionKey;
use App\Enum\RolePermissionEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class RolePermissionKeyFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class RolePermissionKeyFactory implements DataFixtureFactoryInterface
{
    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $titleTranslationKey;

    /**
     * @param RolePermissionEnum $key
     * @param string             $titleTranslationKey
     */
    public function __construct(RolePermissionEnum $key, string $titleTranslationKey)
    {
        $this->key = $key->name;
        $this->titleTranslationKey = $titleTranslationKey;
    }

    /**
     * @inheritDoc
     */
    public function factoryMethod(): EntityInterface
    {
        $rolePermissionKeyEntity = new RolePermissionKey();

        $rolePermissionKeyEntity->setKey($this->key);
        $rolePermissionKeyEntity->setTitle($this->titleTranslationKey);

        return $rolePermissionKeyEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}