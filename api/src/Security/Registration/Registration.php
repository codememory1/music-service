<?php

namespace App\Security\Registration;

use App\Dto\Transfer\RegistrationDto;
use App\Entity\User;
use App\Event\PreUserRegistrationEvent;
use App\Event\SuccessUserRegistrationEvent;
use App\Exception\Http\ConflictException;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Registration
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly UserRepository $userRepository,
        private readonly Registrar $registrar,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function registration(RegistrationDto $dto): User
    {
        $this->validator->validate($dto);

        $user = $this->userRepository->findByEmail($dto->email);

        if (true === $user?->isActive()) {
            throw ConflictException::userByEmailExist();
        }

        $registeredUser = $this->registrar->registrar($dto, $user);

        $this->eventDispatcher->dispatch(new PreUserRegistrationEvent($registeredUser));

        $this->flusher->save($registeredUser);

        $this->eventDispatcher->dispatch(new SuccessUserRegistrationEvent($registeredUser));

        return $registeredUser;
    }
}