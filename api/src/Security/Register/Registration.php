<?php

namespace App\Security\Register;

use App\Dto\Transfer\RegistrationDto;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Event\UserRegistrationEvent;
use App\Exception\HttpException;
use App\Infrastructure\Validator\Validator;
use App\Repository\UserRepository;
use App\Service\FlusherService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Registration
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator,
        private readonly UserRepository $userRepository,
        private readonly Registrar $registrar,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function handle(RegistrationDto $dto): User
    {
        $this->validator->validate($dto);

        $user = $this->userRepository->findByEmail($dto->email);

        if (null !== $user && false === $user->isNotActive()) {
            throw new HttpException(409, PlatformCodeEnum::ENTITY_FOUND, 'user@existByEmail');
        }

        $this->register($dto, $user);

        return $user;
    }

    public function register(RegistrationDto $dto, ?User $user): void
    {
        $registeredUser = $this->registrar->make($dto, $user);

        $this->eventDispatcher->dispatch(new UserRegistrationEvent($registeredUser));

        $this->flusher->save();
    }
}