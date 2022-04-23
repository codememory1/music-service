<?php

namespace App\Security\Auth;

use App\Entity\User;
use App\Enum\EventEnum;
use App\Event\UserAuthorizationEvent;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Authorization.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class Authorization extends AbstractSecurity
{
    /**
     * @var null|EventDispatcherInterface
     */
    private ?EventDispatcherInterface $eventDispatcher = null;

    /**
     * @var null|TokenAuthenticator
     */
    private ?TokenAuthenticator $tokenAuthenticator = null;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return $this
     */
    #[Required]
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): self
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    #[Required]
    public function setTokenAuthenticator(TokenAuthenticator $tokenAuthenticator): self
    {
        $this->tokenAuthenticator = $tokenAuthenticator;

        return $this;
    }

    /**
     * @param User $identifiedUser
     *
     * @return TokenAuthenticator
     */
    public function auth(User $identifiedUser): TokenAuthenticator
    {
        $this->tokenAuthenticator->generateAccessToken($identifiedUser);
        $this->tokenAuthenticator->generateRefreshToken($identifiedUser);

        $this->eventDispatcher->dispatch(
            new UserAuthorizationEvent($identifiedUser, $this->tokenAuthenticator),
            EventEnum::USER_AUTHORIZATION->value
        );

        return $this->tokenAuthenticator;
    }

    /**
     * @param array $tokens
     *
     * @return Response
     */
    public function successAuthResponse(array $tokens): Response
    {
        return $this->responseCollection->successAuth($tokens)->getResponse();
    }
}