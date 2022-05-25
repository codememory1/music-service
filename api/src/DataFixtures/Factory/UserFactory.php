<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\RoleEnum;
use App\Enum\UserProfileStatusEnum;
use App\Enum\UserStatusEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class UserFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class UserFactory implements DataFixtureFactoryInterface
{
    /**
     * @var string
     */
    private string $pseudonym;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string
     */
    private string $role;

    /**
     * @var null|ReferenceRepository
     */
    private ?ReferenceRepository $referenceRepository = null;

    /**
     * @param string   $pseudonym
     * @param string   $email
     * @param string   $password
     * @param RoleEnum $role
     */
    public function __construct(string $pseudonym, string $email, string $password, RoleEnum $role)
    {
        $this->pseudonym = $pseudonym;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role->name;
    }

    /**
     * @inheritDoc
     */
    public function factoryMethod(): EntityInterface
    {
        /** @var Role $role */
        $role = $this->referenceRepository->getReference("r-{$this->role}");

        $userEntity = new User();
        $userProfileEntity = new UserProfile();

        $userProfileEntity->setPseudonym($this->pseudonym);
        $userProfileEntity->setStatus(UserProfileStatusEnum::HIDE);

        $userEntity->setEmail($this->email);
        $userEntity->setPassword($this->password);
        $userEntity->setRole($role);
        $userEntity->setStatus(UserStatusEnum::ACTIVE);
        $userEntity->setProfile($userProfileEntity);

        return $userEntity;
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