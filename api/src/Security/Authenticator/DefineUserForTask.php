<?php

namespace App\Security\Authenticator;

use App\Entity\User;
use App\Interfaces\DefineUserForTaskInterface;
use App\Repository\UserRepository;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class DefineUserForTask
 *
 * @package App\Security\Authenticator
 *
 * @author  Codememory
 */
class DefineUserForTask implements DefineUserForTaskInterface
{
    /**
     * @var Authenticator
     */
    private Authenticator $authenticator;

    /**
     * @var UserRepository|null
     */
    private ?UserRepository $userRepository = null;

    /**
     * @var User|null
     */
    private ?User $definedUser = null;

    /**
     * @param Authenticator $authenticator
     */
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @param UserRepository $userRepository
     *
     * @return $this
     */
    #[Required]
    public function setUserRepository(UserRepository $userRepository): self
    {
        $this->userRepository = $userRepository;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setUserid(?int $userid = null): self
    {
        if (null !== $userid) {
            $user = $this->userRepository->find($userid);
        } else {
            $user = $this->authenticator->getAuthorizedUser();
        }

        $this->definedUser = $user;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDefinedUser(): ?User
    {
        return $this->definedUser;
    }
}