<?php

namespace App\Security\Auth;

use App\Entity\User;
use App\Event\UserAuthorizationEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Authorization
{
    public function __construct(
        private readonly AuthorizationToken $authorizationToken,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function auth(User $authenticatedUser): array
    {
        $accessToken = $this->authorizationToken->generateAccessToken($authenticatedUser)->getAccessToken();
        $refreshToken = $this->authorizationToken->generateRefreshToken($authenticatedUser)->getRefreshToken();

        $this->eventDispatcher->dispatch(new UserAuthorizationEvent(
            $authenticatedUser,
            $this->authorizationToken
        ));

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }
}