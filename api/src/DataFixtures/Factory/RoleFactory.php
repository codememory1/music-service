<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Enum\RoleEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class RoleFactory implements DataFixtureFactoryInterface
{
    private RoleEnum $key;
    private string $titleTranslationKey;
    private string $shortDescriptionTranslationKey;

    public function __construct(RoleEnum $key, string $titleTranslationKey, string $shortDescriptionTranslationKey)
    {
        $this->key = $key;
        $this->titleTranslationKey = $titleTranslationKey;
        $this->shortDescriptionTranslationKey = $shortDescriptionTranslationKey;
    }

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