<?php

namespace App\Security\Auth;

use App\Dto\Transfer\AuthorizationDto;
use App\Entity\User;
use App\Event\UserAuthenticationInAuthEvent;
use App\Exception\Http\AuthorizationException;
use App\Infrastructure\Hashing\Password as PasswordHashing;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Authentication
{
    public function __construct(
        private readonly PasswordHashing $passwordHashing,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function authenticate(AuthorizationDto $dto, User $identifiedUser): User
    {
        $realPassword = $dto->password;
        $hashPassword = $identifiedUser->getPassword();

        if (false === $this->passwordHashing->compare($realPassword, $hashPassword)) {
            throw AuthorizationException::incorrectPassword();
        }

        $this->eventDispatcher->dispatch(new UserAuthenticationInAuthEvent($dto, $identifiedUser));

        return $identifiedUser;
    }
}