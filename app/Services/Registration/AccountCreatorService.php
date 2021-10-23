<?php

namespace App\Services\Registration;

use App\Events\UserRegisterEvent;
use App\Orm\Entities\ActivationTokenEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\PasswordHashingService;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\ActivationTokenService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Event\Exceptions\EventExistException;
use Codememory\Components\Event\Exceptions\EventNotExistException;
use Codememory\Components\Event\Exceptions\EventNotImplementInterfaceException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use ReflectionException;

/**
 * Class AccountCreatorService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class AccountCreatorService extends AbstractApiService
{

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService
     * @throws BuilderNotCurrentSectionException
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    final public function createAccount(EntityManagerInterface $entityManager): ResponseApiCollectorService
    {

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(UserEntity::class);

        // Push the user to the database
        $registeredUser = $this->pushUser($entityManager, $userRepository, $this->getCollectedUserEntity());

        // Saving an activation token for a registered user
        $activationTokenEntity = $this->pushActivationToken($entityManager, $registeredUser);

        // Calling the user registration event
        $this->triggerRegistrationEvent($registeredUser, $activationTokenEntity);

        return $this->createApiResponse(200, 'register.successRegister');

    }

    /**
     * @return UserEntity
     */
    private function getCollectedUserEntity(): UserEntity
    {

        /** @var PasswordHashingService $passwordHashing */
        $passwordHashing = $this->get('password-hashing');
        $inputData = $this->request->post();

        $userEntity = new UserEntity();
        $userEntity
            ->setName($inputData->get('name'))
            ->setEmail($inputData->get('email'))
            ->setUsername($inputData->get('email'))
            ->setPassword($passwordHashing->encode($inputData->get('password')));

        return $userEntity;

    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserEntity             $userEntity
     *
     * @return ActivationTokenEntity
     * @throws InvalidTimezoneException
     */
    private function pushActivationToken(EntityManagerInterface $entityManager, UserEntity $userEntity): ActivationTokenEntity
    {

        /** @var ActivationTokenService $activationToken */
        $activationToken = $this->get('activation-token');

        $activationTokenEntity = new ActivationTokenEntity();
        $activationTokenEntity
            ->setUserId($userEntity->getId())
            ->setToken($activationToken->encode());

        // Saving a token to the database
        $entityManager->commit($activationTokenEntity)->flush();

        return $activationTokenEntity;

    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserRepository         $userRepository
     * @param UserEntity             $userEntity
     *
     * @return UserEntity
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function pushUser(EntityManagerInterface $entityManager, UserRepository $userRepository, UserEntity $userEntity): UserEntity
    {

        // Saving a user to the database
        $entityManager->commit($userEntity)->flush();

        return $userRepository->findOne(['email' => $userEntity->getEmail()]);

    }

    /**
     * @param UserEntity            $userEntity
     * @param ActivationTokenEntity $activationTokenEntity
     *
     * @throws BuilderNotCurrentSectionException
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws ReflectionException
     */
    private function triggerRegistrationEvent(UserEntity $userEntity, ActivationTokenEntity $activationTokenEntity): void
    {

        // Raising the user registration event
        $this->dispatchEvent(UserRegisterEvent::class, [
            $this->get('mailer'),
            $userEntity,
            $activationTokenEntity
        ]);

    }

}