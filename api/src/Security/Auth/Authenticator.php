<?php

namespace App\Security\Auth;

use App\DTO\TokenAuthenticatorDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JwtTokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;

/**
 * Class Authenticator.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class Authenticator
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var TokenAuthenticatorDTO
     */
    private TokenAuthenticatorDTO $tokenAuthenticatorDTO;

    /**
     * @param EntityManagerInterface $em
     * @param TokenAuthenticatorDTO  $tokenAuthenticatorDTO
     */
    public function __construct(EntityManagerInterface $em, TokenAuthenticatorDTO $tokenAuthenticatorDTO)
    {
        $this->em = $em;
        $this->tokenAuthenticatorDTO = $tokenAuthenticatorDTO;
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        /** @var UserRepository $repository */
        $repository = $this->em->getRepository(User::class);

        return $repository->findOneBy(['id' => $this->getAccessTokenData()?->id]);
    }

    /**
     * @return null|object
     */
    public function getAccessTokenData(): ?object
    {
        $jwtTokenGenerator = new JwtTokenGenerator();
        $token = $this->getAccessToken();

        if (!$decoded = $jwtTokenGenerator->decode($token, 'JWT_ACCESS_PUBLIC_KEY')) {
            return null;
        }

        return $decoded;
    }

    /**
     * @return string
     */
    #[Pure]
    public function getAccessToken(): string
    {
        return $this->tokenAuthenticatorDTO->getAccessToken();
    }
}