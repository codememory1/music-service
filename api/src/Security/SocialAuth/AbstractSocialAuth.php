<?php

namespace App\Security\SocialAuth;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\AbstractSecurity;

/**
 * Class AbstractSocialAuth.
 *
 * @package App\Security\SocialAuth
 *
 * @author  Codememory
 */
abstract class AbstractSocialAuth extends AbstractSecurity
{
    /**
     * @var null|string
     */
    protected ?string $typeAuthSocialNetwork = null;

    /**
     * @var null|string
     */
    protected ?string $socialNetworkAuthId = null;

    protected function handler(): void
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);
        $finedUserBySocialNetworkAuthId = $userRepository->findOneBy([
            'typeAuthSocialNetwork' => $this->typeAuthSocialNetwork,
            'socialNetworkAuthId' => $this->socialNetworkAuthId
        ]);
    }
}