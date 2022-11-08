<?php

namespace App\Security\ServiceAuth;

use App\Dto\Interfaces\ServiceAuthorizationDtoInterface;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\EventEnum;
use App\Enum\RoleEnum;
use App\Event\UserRegistrationEvent;
use App\Exception\Http\AuthorizationException;
use App\Infrastructure\Validator\Validator;
use App\Security\Auth\Authorization;
use App\Service\FlusherService;
use App\Service\Platform\Interfaces\ClientInterface;
use App\Service\Platform\Interfaces\UserDataInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractServiceAuthorization
{
    protected ?string $serviceType = null;

    public function __construct(
        protected readonly FlusherService $flusherService,
        protected readonly Validator $validator,
        protected readonly EntityManagerInterface $em,
        protected readonly Authorization $authorization,
        protected readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    abstract public function make(ClientInterface $client, ServiceAuthorizationDtoInterface $dto): array;

    protected function authorizationHandler(ClientInterface $client, ServiceAuthorizationDtoInterface $dto): User
    {
        $this->validator->validate($dto);

        $client->authenticate($dto);

        $userRepository = $this->em->getRepository(User::class);
        $userData = $client->getUserData();
        $user = $userRepository->findByAuthService($userData->getUniqueId(), $this->serviceType);

        if (null === $user) {
            return $this->register($userData);
        }

        return $user;
    }

    protected function register(UserDataInterface $userData): User
    {
        if (empty($userData->getUniqueId()) || empty($userData->getEmail()) || empty($userData->getName())) {
            throw AuthorizationException::didNotProvideData();
        }

        $roleRepository = $this->em->getRepository(Role::class);
        $userProfile = new UserProfile();
        $user = new User();

        $userProfile->setPseudonym($userData->getName());
        $userProfile->setHideStatus();

        $user->setRole($roleRepository->findByKey(RoleEnum::USER));
        $user->setEmail($userData->getEmail());
        $user->setIdInAuthService($userData->getUniqueId());
        $user->setAuthServiceType($this->serviceType);
        $user->setNotActiveStatus();
        $user->setProfile($userProfile);

        $this->validator->validate($user);

        $this->flusherService->addPersist($user);

        $this->eventDispatcher->dispatch(
            new UserRegistrationEvent($user),
            EventEnum::REGISTER->value
        );

        $this->em->flush();

        return $user;
    }

    protected function auth(User $user): array
    {
        return $this->authorization->auth($user);
    }
}