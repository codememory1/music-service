<?php

namespace App\Service\Security;

use App\Entity\Role;
use App\Entity\User;
use App\Enums\EventsEnum;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Event\UserRegistrationEvent;
use App\Repository\RoleRepository;
use App\Service\AbstractApiService;
use App\Service\PasswordHashingService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserRegistrationService
 *
 * @package App\Service\Security
 *
 * @author  Codememory
 */
class UserRegistrationService extends AbstractApiService
{

    /**
     * @param ValidatorInterface       $validator
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function register(ValidatorInterface $validator, EventDispatcherInterface $eventDispatcher): ApiResponseService
    {

        $creatorAccountActivationTokenService = new CreatorAccountActivationTokenService($this->managerRegistry);

        $collectedEntity = $this->collectEntity();

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Hashing password
        $this->hashPassword($collectedEntity);

        // Raises an event after user registration
        $this->setHandler(function (User $registeredUser) use ($eventDispatcher, $creatorAccountActivationTokenService) {
            // Create activation token
            $creatorAccountActivationTokenService->create($registeredUser);

            $eventDispatcher->dispatch(
                new UserRegistrationEvent($registeredUser),
                EventsEnum::USER_REGISTRATION->value
            );
        });

        // User registration
        return $this->push($collectedEntity, 'user@successRegister');

    }

    /**
     * @return User
     */
    private function collectEntity(): User
    {

        $userEntity = new User();

        $email = $this->request->get('email', '');

        $userEntity
            ->setEmail($email)
            ->setUsername($this->getUsernameFromEmail($email))
            ->setPassword($this->request->get('password', ''))
            ->setPasswordConfirm($this->request->get('password_confirm', ''))
            ->setRole($this->getUserRole())
            ->setStatus(StatusEnum::NOT_ACTIVE->value);

        return $userEntity;

    }

    /**
     * @param User $userEntity
     *
     * @return void
     */
    private function hashPassword(User $userEntity): void
    {

        $passwordHashingService = new PasswordHashingService();

        $userEntity->setPassword($passwordHashingService->encode(
            $userEntity->getPassword()
        ));

    }

    /**
     * @return Role
     */
    private function getUserRole(): Role
    {

        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->em->getRepository(Role::class);

        return $roleRepository->findOneBy([
            'key' => RoleEnum::USER->value
        ]);

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

}