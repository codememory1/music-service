<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\UserSession;
use App\Repository\UserRepository;
use App\Repository\UserSessionRepository;
use App\Security\Http\BearerToken;
use Doctrine\ORM\EntityManagerInterface;

class AuthorizedUser
{
    private UserRepository $userRepository;
    private UserSessionRepository $userSessionRepository;
    private BearerToken $bearerToken;
    private ?string $accessToken;
    private ?User $user = null;
    private ?UserSession $userSession = null;

    public function __construct(EntityManagerInterface $manager, BearerToken $bearerToken)
    {
        $this->userRepository = $manager->getRepository(User::class);
        $this->userSessionRepository = $manager->getRepository(UserSession::class);
        $this->bearerToken = $bearerToken;

        $this->accessToken = $this->bearerToken->getToken();
    }

    public function setAccessToken(string $token): self
    {
        $this->accessToken = $token;

        $this->bearerToken->setToken($this->accessToken);

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

        if (false !== $tokenData = $this->bearerToken->getData()) {
            $user = $this->userRepository->find($tokenData['id']);

            $this->userSession = $this->userSessionRepository->findByAccessTokenWithUser($user, $this->bearerToken->getToken());
        }

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