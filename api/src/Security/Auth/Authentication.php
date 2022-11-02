<?php

namespace App\Security\Auth;

use App\Dto\Transfer\AuthorizationDto;
use App\Entity\User;
use App\Event\UserAuthenticationInAuthEvent;
use App\Exception\Http\AuthorizationException;
use App\Service\HashingService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Authentication
{
    public function __construct(
        private readonly HashingService $hashing,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function authenticate(AuthorizationDto $authorizationDto, User $identifiedUser): User
    {
        $realPassword = $authorizationDto->password;
        $hashPassword = $identifiedUser->getPassword();

        if (false === $this->hashing->compare($realPassword, $hashPassword)) {
            throw AuthorizationException::incorrectPassword();
        }

        $this->eventDispatcher->dispatch(new UserAuthenticationInAuthEvent(
            $authorizationDto,
            $identifiedUser
        ));

        return $identifiedUser;
    }
}