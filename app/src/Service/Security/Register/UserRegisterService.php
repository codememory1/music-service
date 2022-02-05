<?php

namespace App\Service\Security\Register;

use App\Entity\Role;
use App\Entity\User;
use App\Enums\EventsEnum;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Event\UserRegistrationEvent;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Service\AbstractApiService;
use App\Service\PasswordHashingService;
use App\Service\Response\ApiResponseService;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserRegisterService
 *
 * @package App\Service\Security\Register
 *
 * @author  codememory
 */
class UserRegisterService extends AbstractApiService
{

    /**
     * @param ValidatorInterface       $validator
     * @param EventDispatcherInterface $dispatcher
     *
     * @return ApiResponseService
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function register(ValidatorInterface $validator, EventDispatcherInterface $dispatcher): ApiResponseService
    {

        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);
        $isReRegistration = $this->isReRegistration($userRepository);
        $collectedEntity = $this->collectEntity($isReRegistration);

        // Input POST validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Hash password after validation
        $this->hashPassword($collectedEntity);

        // Generating or updating an activation token if re-registration is in progress
        $this->createActivationToken($collectedEntity);

        // Adding a handler after user registration
        $this->setHandler(function(User $registeredUser) use ($dispatcher) {
            $userRegistrationEvent = new UserRegistrationEvent($registeredUser);

            $dispatcher->dispatch($userRegistrationEvent, EventsEnum::USER_REGISTRATION->value);
        });

        // User registration or updates if re-registration
        return $this->push($collectedEntity, 'user@successRegister', null !== $isReRegistration);

    }

    /**
     * @param User|null $userEntity
     *
     * @return User
     */
    private function collectEntity(?User $userEntity = null): User
    {

        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->em->getRepository(Role::class);
        $email = $this->request->get('email', '');

        $userEntity = $userEntity ?? new User();
        $userEntity
            ->setEmail($email)
            ->setUsername($this->getUsernameFromEmail($email))
            ->setPassword($this->request->get('password', ''))
            ->setPasswordConfirm($this->request->get('password_confirm', ''))
            ->setStatus(StatusEnum::ACTIVE->value)
            ->setRole($roleRepository->findOneBy(['key' => RoleEnum::USER->value]));

        return $userEntity;

    }

    /**
     * @param string $email
     *
     * @return string
     */
    private function getUsernameFromEmail(string $email): string
    {

        return explode('@', $email)[0];

    }

    /**
     * @param UserRepository $userRepository
     *
     * @return User|null
     * @throws NonUniqueResultException
     */
    private function isReRegistration(UserRepository $userRepository): ?User
    {

        return $userRepository->findByLogin($this->request->get('email'));

    }

    /**
     * @param User $userEntity
     *
     * @return void
     */
    private function hashPassword(User $userEntity): void
    {

        $hashingPasswordService = new PasswordHashingService();

        $userEntity->setPassword(
            $hashingPasswordService->encode(
                $this->request->get('password', '')
            )
        );

    }

    /**
     * @param User $registeredUser
     *
     * @return void
     */
    private function createActivationToken(User $registeredUser): void
    {

        $creatorActivationTokenService = new CreatorActivationTokenService($this->em);

        $creatorActivationTokenService->create($registeredUser);

    }

}