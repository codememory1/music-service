<?php

namespace App\Service\Security\Register;

use App\Entity\User;
use App\Entity\UserActivationToken;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class CreatorActivationTokenService.
 *
 * @package App\Service\Security\Register
 *
 * @author  Codememory
 */
class CreatorActivationTokenService
{
    /**
     * @var ObjectManager
     */
    private ObjectManager $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->em = $managerRegistry->getManager();
    }

    /**
     * @param User $userEntity
     *
     * @return void
     */
    public function create(User $userEntity): void
    {
        $userActivationTokenEntity = $userEntity->getUserActivationToken() ?? new UserActivationToken();

        $userActivationTokenEntity
            ->setUser($userEntity)
            ->setValid($_ENV['ACCOUNT_ACTIVATION_TOKEN_TTL'])
            ->setToken($this->generateActivationToken($userEntity));

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
            'email' => $userEntity->getEmail(),
            'random' => Uuid::uuid4()->toString()
        ];

        return base64_encode(implode('.', $payload));
    }
}