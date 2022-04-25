<?php

namespace App\Service\UserActivationToken;

use App\Entity\UserActivationToken;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DeleterToken.
 *
 * @package App\Service\UserActivationToken
 *
 * @author  Codememory
 */
class DeleterToken
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param UserActivationToken $userActivationToken
     *
     * @return UserActivationToken
     */
    public function delete(UserActivationToken $userActivationToken): UserActivationToken
    {
        $this->em->remove($userActivationToken);
        $this->em->flush();

        return $userActivationToken;
    }
}