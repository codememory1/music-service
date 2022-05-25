<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Enum\RoleEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class RoleFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class RoleFactory implements DataFixtureFactoryInterface
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
     * @var string
     */
    private string $shortDescriptionTranslationKey;

    /**
     * @param RoleEnum $key
     * @param string   $titleTranslationKey
     * @param string   $shortDescriptionTranslationKey
     */
    public function __construct(RoleEnum $key, string $titleTranslationKey, string $shortDescriptionTranslationKey)
    {
        $this->key = $key->name;
        $this->titleTranslationKey = $titleTranslationKey;
        $this->shortDescriptionTranslationKey = $shortDescriptionTranslationKey;
    }

    /**
     * @inheritDoc
     */
    public function factoryMethod(): EntityInterface
    {
        $roleEntity = new Role();

        $roleEntity->setKey($this->key);
        $roleEntity->setTitle($this->titleTranslationKey);
        $roleEntity->setShortDescription($this->shortDescriptionTranslationKey);

        return $roleEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}