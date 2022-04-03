<?php

namespace App\Service\Security\Register;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Enum\EventsEnum;
use App\Event\UserRegistrationEvent;
use App\Repository\UserRepository;
use App\Rest\ApiService;
use App\Rest\Http\Response;
use App\Service\PasswordHashingService;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class UserRegisterService.
 *
 * @package App\Service\Security\Register
 *
 * @author  codememory
 */
class UserRegisterService extends ApiService
{
    /**
     * @param RegistrationDTO          $registrationDTO
     * @param EventDispatcherInterface $dispatcher
     *
     * @throws NonUniqueResultException
     *
     * @return Response
     */
    public function register(RegistrationDTO $registrationDTO, EventDispatcherInterface $dispatcher): Response
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);
        $isReRegistration = $this->isReRegistration($userRepository, $registrationDTO);

        /** @var User $collectedEntity */
        $collectedEntity = $registrationDTO->updateEntity($isReRegistration)->getCollectedEntity();

        $collectedEntity->setUsername($registrationDTO->username);

        // Validation of input POST data
        if (true !== $resultInputValidation = $this->inputValidation($registrationDTO)) {
            return $resultInputValidation;
        }

        // Validation when inserting into the database
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity)) {
            return $resultInputValidation;
        }

        // Hash password after validation
        $this->hashPassword($collectedEntity, $registrationDTO);

        // Generating or updating an activation token if re-registration is in progress
        $this->createActivationToken($collectedEntity);

        // Adding a handler after user registration
        $this->manager->setHandlerAfterFlush(function(User $registeredUser) use ($dispatcher): void {
            $userRegistrationEvent = new UserRegistrationEvent($registeredUser);

            $dispatcher->dispatch($userRegistrationEvent, EventsEnum::USER_REGISTRATION->value);
        });

        // User registration or updates if re-registration
        if (null !== $isReRegistration) {
            $this->manager->update($collectedEntity, 'user@successRegister');
        }

        return $this->manager->push($collectedEntity, 'user@successRegister');
    }

    /**
     * @param UserRepository  $userRepository
     * @param RegistrationDTO $registrationDTO
     *
     * @throws NonUniqueResultException
     *
     * @return null|User
     */
    private function isReRegistration(UserRepository $userRepository, RegistrationDTO $registrationDTO): ?User
    {
        return $userRepository->findByLogin($registrationDTO->email);
    }

    /**
     * @param User            $userEntity
     * @param RegistrationDTO $registrationDTO
     *
     * @return void
     */
    private function hashPassword(User $userEntity, RegistrationDTO $registrationDTO): void
    {
        $hashingPasswordService = new PasswordHashingService();
        $encodedPassword = $hashingPasswordService->encode($registrationDTO->password);

        $userEntity->setPassword($encodedPassword);
    }

    /**
     * @param User $registeredUser
     *
     * @return void
     */
    private function createActivationToken(User $registeredUser): void
    {
        $creatorActivationTokenService = new CreatorActivationTokenService($this->managerRegistry);

        $creatorActivationTokenService->create($registeredUser);
    }
}