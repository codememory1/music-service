<?php

namespace App\Services\Registration;

use App\Orm\Entities\ActivationTokenEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\PasswordHashingService;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\ActivationTokenService;
use App\Services\Translation\DataService;
use App\Tasks\UserRegisterTask;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
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
     * @param UserRepository $userRepository
     *
     * @return ResponseApiCollectorService
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function createAccount(UserRepository $userRepository): ResponseApiCollectorService
    {

        // Push the user to the database
        $registeredUser = $this->pushUser($userRepository, $this->getCollectedUserEntity());

        // Saving an activation token for a registered user
        $activationTokenEntity = $this->pushActivationToken($registeredUser);

        // Calling the user registration event
        $this->triggerRegistrationEvent($registeredUser, $activationTokenEntity);

        return $this->createApiResponse(200, 'register@successRegister');

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
     * @param UserEntity $userEntity
     *
     * @return ActivationTokenEntity
     * @throws InvalidTimezoneException
     */
    private function pushActivationToken(UserEntity $userEntity): ActivationTokenEntity
    {

        /** @var ActivationTokenService $activationToken */
        $activationToken = $this->get('activation-token');

        $activationTokenEntity = new ActivationTokenEntity();
        $activationTokenEntity
            ->setUserId($userEntity->getId())
            ->setToken($activationToken->encode());

        // Saving a token to the database
        $this->getEntityManager()->commit($activationTokenEntity)->flush();

        return $activationTokenEntity;

    }

    /**
     * @param UserRepository $userRepository
     * @param UserEntity     $userEntity
     *
     * @return UserEntity
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function pushUser(UserRepository $userRepository, UserEntity $userEntity): UserEntity
    {

        // Saving a user to the database
        $this->getEntityManager()->commit($userEntity)->flush();

        return $userRepository->findOne(['email' => $userEntity->getEmail()]);

    }

    /**
     * @param UserEntity            $userEntity
     * @param ActivationTokenEntity $activationTokenEntity
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function triggerRegistrationEvent(UserEntity $userEntity, ActivationTokenEntity $activationTokenEntity): void
    {

        /** @var DataService $translationsFromDb */
        $translationsFromDb = $this->getService('Translation\Data');

        $this->dispatchJob(UserRegisterTask::class, [
            'email'            => $userEntity->getEmail(),
            'activation-token' => $activationTokenEntity->getToken(),
            'subject'          => $translationsFromDb->getTranslationByKey('confirmRegistration')
        ]);

    }

}