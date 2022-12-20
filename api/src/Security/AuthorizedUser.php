<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\UserSession;
use App\Repository\UserRepository;
use App\Repository\UserSessionRepository;
use App\Rest\Jwt\AccessToken;
use App\Security\Http\BearerToken;

final class AuthorizedUser
{
    private ?User $user = null;
    private ?UserSession $userSession = null;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserSessionRepository $userSessionRepository,
        private readonly AccessToken $accessToken,
        public readonly BearerToken $bearerToken
    ) {
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
        $user = $this->userRepository->find($accessTokenData['id']);

        $this->userSession = null === $user ? null : $this->userSessionRepository->findByAccessTokenWithUser(
            $user,
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