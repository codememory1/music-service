<?php

namespace App\UseCase\Auth;

use App\Entity\User;
use App\Exceptions\BadException;
use App\Exceptions\AccessIsDeniedException;
use App\Repository\UserRepository;

final class Identification
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    /**
     * @throws BadException
     * @throws AccessIsDeniedException
     */
    public function process(string $email): User
    {
        $user = $this->userRepository->findByEmail($email);

        if (null === $user || null !== $user->getRemovedAt()) {
            throw BadException::invalidEmailOrPassword();
        }

        if ($user->isNotActivated()) {
            throw AccessIsDeniedException::authorizationFailedUserIsNotActivated();
        }

        if ($user->isLocked()) {
            throw AccessIsDeniedException::authorizationFailedUserBlocked();
        }

        return $user;
    }
}