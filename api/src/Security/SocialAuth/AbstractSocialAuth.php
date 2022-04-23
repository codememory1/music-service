<?php

namespace App\Security\SocialAuth;

use App\Entity\Role;
use App\Entity\User;
use App\Enum\RoleEnum;
use App\Enum\UserStatusEnum;
use App\Interfaces\AuthorizationTokenInterface;
use App\Interfaces\SocialNetworkUserInfoInterface;
use App\Repository\UserRepository;
use App\Security\AbstractSecurity;
use App\Security\Auth\Authorization;
use App\Utils\EmailUtil;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AbstractSocialAuth.
 *
 * @package App\Security\SocialAuth
 *
 * @author  Codememory
 */
abstract class AbstractSocialAuth extends AbstractSecurity
{
    /**
     * @var null|string
     */
    protected ?string $typeAuthSocialNetwork = null;

    /**
     * @var null|Authorization
     */
    protected ?Authorization $authorization = null;

    /**
     * @param string $code
     *
     * @return AuthorizationTokenInterface
     */
    abstract public function make(string $code): AuthorizationTokenInterface;

    /**
     * @param SocialNetworkUserInfoInterface $socialNetworkUserInfo
     *
     * @return AuthorizationTokenInterface
     */
    protected function handler(SocialNetworkUserInfoInterface $socialNetworkUserInfo): AuthorizationTokenInterface
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);
        $user = $userRepository->findOneBy([
            'typeAuthSocialNetwork' => $this->typeAuthSocialNetwork,
            'socialNetworkAuthId' => $socialNetworkUserInfo->getUniqueId()
        ]);

        if (null === $user) {
            $user = $this->register($socialNetworkUserInfo);
        }

        return $this->authorize($user);
    }

    /**
     * @param Authorization $authorization
     *
     * @return $this
     */
    #[Required]
    public function setAuthorization(Authorization $authorization): self
    {
        $this->authorization = $authorization;

        return $this;
    }

    /**
     * @param User $finedUser
     *
     * @return AuthorizationTokenInterface
     */
    private function authorize(User $finedUser): AuthorizationTokenInterface
    {
        return $this->authorization->auth($finedUser);
    }

    /**
     * @param SocialNetworkUserInfoInterface $socialNetworkUserInfo
     *
     * @return User
     */
    private function register(SocialNetworkUserInfoInterface $socialNetworkUserInfo): User
    {
        $emailToUsernameUtil = new EmailUtil($socialNetworkUserInfo->getEmail());
        $roleRepository = $this->em->getRepository(Role::class);
        $user = new User();

        $user
            ->setPassword('err')
            ->setTypeAuthSocialNetwork($this->typeAuthSocialNetwork)
            ->setSocialNetworkAuthId($socialNetworkUserInfo->getUniqueId())
            ->setRole($roleRepository->findOneBy(['key' => RoleEnum::USER->value]))
            ->setEmail($socialNetworkUserInfo->getEmail())
            ->setUsername($emailToUsernameUtil->getUsername())
            ->setStatus(UserStatusEnum::ACTIVE);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}