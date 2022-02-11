<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JwtTokenGenerator;

/**
 * Class TokenAuthenticator
 *
 * @package App\Security
 *
 * @author  Codememory
 */
class TokenAuthenticator extends AbstractSecurity
{

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {

        $header = $this->request->headers->get('Authorization');

        if (null === $header) {
            return null;
        }

        return explode(' ', $header, 2)[1] ?? null;

    }

    /**
     * @return object|null
     */
    public function getAccessTokenData(): ?object
    {

        $jwtTokenGenerator = new JwtTokenGenerator();
        $token = $this->getAccessToken();

        if (null == $token || !$decoded = $jwtTokenGenerator->decode($token, $_ENV['JWT_ACCESS_PUBLIC_KEY'])) {
            return null;
        }

        return $decoded;

    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {

        /** @var UserRepository $repository */
        $repository = $this->em->getRepository(User::class);

        return $repository->findOneBy(['id' => $this->getAccessTokenData()?->id]);

    }

}