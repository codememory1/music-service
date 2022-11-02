<?php

namespace App\Security\Auth;

use App\Entity\User;
use App\Event\UserAuthorizationEvent;
use App\Rest\Response\HttpResponseCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class Authorization
{
    public function __construct(
        private readonly AuthorizationToken $authorizationToken,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly HttpResponseCollection $responseCollection
    ) {
    }

    public function auth(User $authenticatedUser): JsonResponse
    {
        $accessToken = $this->authorizationToken->generateAccessToken($authenticatedUser)->getAccessToken();
        $refreshToken = $this->authorizationToken->generateRefreshToken($authenticatedUser)->getRefreshToken();

        $this->eventDispatcher->dispatch(new UserAuthorizationEvent(
            $authenticatedUser,
            $this->authorizationToken
        ));

        return $this->responseCollection->successAuthorization([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ]);
    }
}