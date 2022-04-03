<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Rest\Http\Request;
use App\Service\JwtTokenGenerator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TokenAuthenticator.
 *
 * @package App\Security
 *
 * @author  Codememory
 */
class TokenAuthenticator
{
    /**
     * @param Request         $request
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(Request $request, ManagerRegistry $managerRegistry)
    {
        $this->request = $request;
        $this->em = $managerRegistry->getManager();
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

        if (null === $token || !$decoded = $jwtTokenGenerator->decode($token, $_ENV['JWT_ACCESS_PUBLIC_KEY'])) {
            return null;
        }

        return $decoded;
    }

    /**
     * @return null|string
     */
    public function getAccessToken(): ?string
    {
        $header = $this->request->request->headers->get('Authorization');

        if (null === $header) {
            return null;
        }

        return explode(' ', $header, 2)[1] ?? null;
    }
}