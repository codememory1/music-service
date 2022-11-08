<?php

namespace App\Security\Auth;

use App\Dto\Transfer\AuthorizationDto;
use App\Entity\User;
use App\Event\UserIdentificationInAuthEvent;
use App\Exception\Http\AuthorizationException;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Identification
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function identify(AuthorizationDto $dto): ?User
    {
        $identifiedUser = $this->userRepository->findByEmail($dto->email);

        if (null === $identifiedUser) {
            throw AuthorizationException::failedToIdentify();
        }

        $this->eventDispatcher->dispatch(new UserIdentificationInAuthEvent($dto, $identifiedUser));

        return $identifiedUser;
    }
}