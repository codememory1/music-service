<?php

namespace App\Security\ServiceAuth;

use App\Dto\Interfaces\ServiceAuthorizationDtoInterface;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\EventEnum;
use App\Enum\RoleEnum;
use App\Event\UserRegistrationEvent;
use App\Repository\UserRepository;
use App\Rest\Http\Exceptions\AuthorizationException;
use App\Security\Auth\Authorization;
use App\Service\AbstractService;
use App\Service\Platform\Interfaces\ClientInterface;
use App\Service\Platform\Interfaces\UserDataInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AbstractServiceAuthorization.
 *
 * @package App\Security\ServiceAuth
 *
 * @author  Codememory
 */
abstract class AbstractServiceAuthorization extends AbstractService
{
    protected ?string $serviceType = null;

    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    #[Required]
    public ?UserRepository $userRepository = null;

    #[Required]
    public ?Authorization $authorization = null;

    abstract public function make(ClientInterface $client, ServiceAuthorizationDtoInterface $serviceAuthorizationDto): JsonResponse;

    protected function authorizationHandler(ClientInterface $client, ServiceAuthorizationDtoInterface $serviceAuthorizationDto): JsonResponse
    {
        $this->validate($serviceAuthorizationDto);

        $client->authenticate($serviceAuthorizationDto);

        $userData = $client->getUserData();

        $finedUserByAuthService = $this->userRepository->findOneBy([
            'idInAuthService' => $userData->getUniqueId(),
            'authServiceType' => $this->serviceType
        ]);

        if (null === $finedUserByAuthService) {
            return $this->register($userData);
        }

        return $this->auth($finedUserByAuthService);
    }

    protected function register(UserDataInterface $userData): JsonResponse
    {
        if (empty($userData->getUniqueId()) || empty($userData->getEmail()) || empty($userData->getName())) {
            throw AuthorizationException::didNotProvideData();
        }

        $roleRepository = $this->em->getRepository(Role::class);
        $userProfile = new UserProfile();
        $user = new User();

        $userProfile->setPseudonym($userData->getName());
        $userProfile->setHideStatus();

        $user->setRole($roleRepository->findOneBy(['key' => RoleEnum::USER->name]));
        $user->setEmail($userData->getEmail());
        $user->setIdInAuthService($userData->getUniqueId());
        $user->setAuthServiceType($this->serviceType);
        $user->setNotActiveStatus();
        $user->setProfile($userProfile);

        $this->validate($user);

        $this->flusherService->addPersist($user);

        $this->eventDispatcher->dispatch(
            new UserRegistrationEvent($user),
            EventEnum::REGISTER->value
        );

        $this->em->flush();

        return $this->responseCollection->successRegistration();
    }

    protected function auth(User $authorizedUser): JsonResponse
    {
        return $this->authorization->auth($authorizedUser);
    }
}