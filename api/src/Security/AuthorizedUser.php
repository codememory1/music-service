<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\UserSession;
use App\Repository\UserRepository;
use App\Repository\UserSessionRepository;
use App\Rest\Jwt\AccessToken;
use App\Security\Http\BearerToken;

class AuthorizedUser
{
    private UserRepository $userRepository;
    private UserSessionRepository $userSessionRepository;
    private AccessToken $accessToken;
    private BearerToken $bearerToken;
    private ?User $user = null;
    private ?UserSession $userSession = null;

    public function __construct(UserRepository $userRepository, UserSessionRepository $userSessionRepository, AccessToken $accessToken, BearerToken $bearerToken)
    {
        $this->userRepository = $userRepository;
        $this->userSessionRepository = $userSessionRepository;
        $this->accessToken = $accessToken;
        $this->bearerToken = $bearerToken;
    }

    public function setAccessToken(string $token): self
    {
        $this->accessToken->setToken($token);

        return $this;
    }

    public function fromBearer(): self
    {
        if (null !== $token = $this->bearerToken->getToken()) {
            $this->setAccessToken($token);
        }

        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUserSession(): ?UserSession
    {
        if (null !== $this->userSession) {
            return $this->userSession;
        }

        if (false === $this->accessToken->isValid()) {
            return null;
        }

        $accessTokenData = $this->accessToken->getData();

        $this->userSession = $this->userSessionRepository->findByAccessTokenWithUser(
            $this->userRepository->find($accessTokenData['id']),
            $this->accessToken->getToken()
        );

        return $this->userSession;
    }

    public function getUser(): ?User
    {
        if (null === $this->user) {
            $this->user = $this->getUserSession()?->getUser();
        }

        return $this->user;
    }
}