<?php

namespace App\Service\Security\Register;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use App\Enum\EventsEnum;
use App\Event\UserRegistrationEvent;
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
     * @param RegistrationDTO          $registrationDTO
     * @param ValidatorInterface       $validator
     * @param EventDispatcherInterface $dispatcher
     *
     * @return ApiResponseService
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function register(RegistrationDTO $registrationDTO, ValidatorInterface $validator, EventDispatcherInterface $dispatcher): ApiResponseService
    {

        /** @var UserRepository $userRepository */
        $userRepository = $this->em->getRepository(User::class);
        $isReRegistration = $this->isReRegistration($userRepository, $registrationDTO);

        /** @var User $collectedEntity */
        $collectedEntity = $registrationDTO->update($isReRegistration)->getCollectedEntity();

        $collectedEntity->setUsername($registrationDTO->getUsername());

        // Validation of input POST data
        if (true !== $resultInputValidation = $this->inputValidation($registrationDTO, $validator)) {
            return $resultInputValidation;
        }

        // Validation when inserting into the database
        if (true !== $resultInputValidation = $this->inputValidation($collectedEntity, $validator)) {
            return $resultInputValidation;
        }

        // Hash password after validation
        $this->hashPassword($collectedEntity, $registrationDTO);

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
     * @param UserRepository  $userRepository
     * @param RegistrationDTO $registrationDTO
     *
     * @return User|null
     * @throws NonUniqueResultException
     */
    private function isReRegistration(UserRepository $userRepository, RegistrationDTO $registrationDTO): ?User
    {

        return $userRepository->findByLogin($registrationDTO->getEmail());

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
        $encodedPassword = $hashingPasswordService->encode($registrationDTO->getPassword());

        $userEntity->setPassword($encodedPassword);

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