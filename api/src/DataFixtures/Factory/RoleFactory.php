<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Enum\RoleEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class RoleFactory implements DataFixtureFactoryInterface
{
    public function __construct(
        private readonly RoleEnum $key,
        private readonly string $titleTranslationKey,
        private readonly string $shortDescriptionTranslationKey
    ) {}

    public function factoryMethod(): EntityInterface
    {
        $role = new Role();

        $role->setKey($this->key->name);
        $role->setTitle($this->titleTranslationKey);
        $role->setShortDescription($this->shortDescriptionTranslationKey);

        return $role;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}