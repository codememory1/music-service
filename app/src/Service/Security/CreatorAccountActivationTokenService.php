<?php

namespace App\Service\Security;

use App\Entity\User;
use App\Entity\UserActivationToken;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CreatorAccountActivationTokenService
 *
 * @package App\Service\Security
 *
 * @author  codememory
 */
class CreatorAccountActivationTokenService
{

    /**
     * @var ObjectManager
     */
    private ObjectManager $em;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {

        $this->em = $managerRegistry->getManager();

    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function create(User $user): void
    {

        $userActivationTokenEntity = new UserActivationToken();

        $userActivationTokenEntity
            ->setUser($user)
            ->setValid($_ENV['ACCOUNT_ACTIVATION_TOKEN_TTL'])
            ->setToken($this->generateActivationToken($user));

        $this->em->persist($userActivationTokenEntity);
        $this->em->flush();

    }

    /**
     * @param User $userEntity
     *
     * @return string
     */
    private function generateActivationToken(User $userEntity): string
    {

        $payload = [
            'user_id' => $userEntity->getId(),
            'email'   => $userEntity->getEmail(),
            'random'  => Uuid::uuid4()->toString()
        ];

        return base64_encode(implode('.', $payload));

    }

}