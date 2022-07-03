<?php

namespace App\Security\ServiceAuth;

use App\DTO\Interfaces\ServiceAuthorizationDTOInterface;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\EventEnum;
use App\Enum\RoleEnum;
use App\Enum\UserProfileStatusEnum;
use App\Enum\UserStatusEnum;
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

    abstract public function make(ClientInterface $client, ServiceAuthorizationDTOInterface $serviceAuthorizationDTO): JsonResponse;

    protected function authorizationHandler(ClientInterface $client, ServiceAuthorizationDTOInterface $serviceAuthorizationDTO): JsonResponse
    {
        if (false === $this->validate($serviceAuthorizationDTO)) {
            return $this->validator->getResponse();
        }

        $client->authenticate($serviceAuthorizationDTO);

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
        $userProfileEntity = new UserProfile();
        $userEntity = new User();

        $userProfileEntity->setPseudonym($userData->getName());
        $userProfileEntity->setStatus(UserProfileStatusEnum::HIDE);

        $userEntity->setRole($roleRepository->findOneBy(['key' => RoleEnum::USER->name]));
        $userEntity->setEmail($userData->getEmail());
        $userEntity->setIdInAuthService($userData->getUniqueId());
        $userEntity->setAuthServiceType($this->serviceType);
        $userEntity->setStatus(UserStatusEnum::NOT_ACTIVE);
        $userEntity->setProfile($userProfileEntity);

        if (false === $this->validate($userEntity)) {
            return $this->validator->getResponse();
        }

        $this->em->persist($userEntity);

        $this->eventDispatcher->dispatch(
            new UserRegistrationEvent($userEntity),
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