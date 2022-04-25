<?php

namespace App\Security\SocialAuth;

use App\Entity\User;
use App\Interfaces\AuthorizationTokenInterface;
use App\Interfaces\SocialNetworkUserInfoInterface;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Security\Auth\Authorization;
use App\Security\Registration\CreatorAccount;
use App\Service\PasswordGeneratorService;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
     * @var CreatorAccount|null
     */
    protected ?CreatorAccount $creatorAccount = null;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $code
     *
     * @return Response|AuthorizationTokenInterface
     */
    abstract public function make(EventDispatcherInterface $eventDispatcher, string $code): Response|AuthorizationTokenInterface;

    /**
     * @param CreatorAccount $creatorAccount
     *
     * @return $this
     */
    #[Required]
    public function setCreatorAccount(CreatorAccount $creatorAccount): self
    {
        $this->creatorAccount = $creatorAccount;

        return $this;
    }

    /**
     * @param SocialNetworkUserInfoInterface $socialNetworkUserInfo
     * @param EventDispatcherInterface       $eventDispatcher
     *
     * @return Response|AuthorizationTokenInterface
     * @throws Exception
     */
    protected function handler(SocialNetworkUserInfoInterface $socialNetworkUserInfo, EventDispatcherInterface $eventDispatcher): Response|AuthorizationTokenInterface
    {
        $userRepository = $this->em->getRepository(User::class);
        $user = $userRepository->findOneBy([
            'typeAuthSocialNetwork' => $this->typeAuthSocialNetwork,
            'socialNetworkAuthId' => $socialNetworkUserInfo->getUniqueId()
        ]);

        if (null === $user) {
            return $this->register($socialNetworkUserInfo, $eventDispatcher);
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
     * @param EventDispatcherInterface       $eventDispatcher
     *
     * @return Response|AuthorizationTokenInterface
     * @throws Exception
     */
    private function register(SocialNetworkUserInfoInterface $socialNetworkUserInfo, EventDispatcherInterface $eventDispatcher): Response|AuthorizationTokenInterface
    {
        $createdUserAccount = $this->createUserAccount($socialNetworkUserInfo, $eventDispatcher);

        if ($createdUserAccount instanceof Response) {
            return $createdUserAccount;
        }

        return $this->authorize($createdUserAccount);
    }

    /**
     * @param SocialNetworkUserInfoInterface $socialNetworkUserInfo
     * @param EventDispatcherInterface       $eventDispatcher
     *
     * @return Response|User
     * @throws Exception
     */
    private function createUserAccount(SocialNetworkUserInfoInterface $socialNetworkUserInfo, EventDispatcherInterface $eventDispatcher): Response|User
    {
        $userEntity = new User();
        $userEntity
            ->setPassword(PasswordGeneratorService::generate())
            ->setTypeAuthSocialNetwork($this->typeAuthSocialNetwork)
            ->setSocialNetworkAuthId($socialNetworkUserInfo->getUniqueId())
            ->setEmail($socialNetworkUserInfo->getEmail());

        return $this->creatorAccount->create($userEntity, $eventDispatcher);
    }
}