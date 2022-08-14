<?php

namespace App\Security\Auth;

use App\Dto\Transfer\AuthorizationDto;
use App\Entity\User;
use App\Event\UserAuthenticationInAuthEvent;
use App\Rest\Http\Exceptions\AuthorizationException;
use App\Service\HashingService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Authentication
{
    #[Required]
    public ?HashingService $hashingService = null;

    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function authenticate(AuthorizationDto $authorizationDto, User $identifiedUser): User
    {
        $realPassword = $authorizationDto->password;
        $hashPassword = $identifiedUser->getPassword();

        if (false === $this->hashingService->compare($realPassword, $hashPassword)) {
            throw AuthorizationException::incorrectPassword();
        }

        $this->eventDispatcher->dispatch(new UserAuthenticationInAuthEvent(
            $authorizationDto,
            $identifiedUser
        ));

        return $identifiedUser;
    }
}