<?php

namespace App\Services\Registration;

use App\Orm\Entities\ActivationTokenEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\ActivationTokenRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\ActivationTokenService;
use App\Services\Translation\DataService;
use App\Tasks\UserRegisterTask;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class RefresherActivationTokenService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class RefresherActivationTokenService extends AbstractApiService
{

    /**
     * @param UserEntity $userEntity
     *
     * @return RefresherActivationTokenService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function refresh(UserEntity $userEntity): RefresherActivationTokenService
    {

        /** @var ActivationTokenRepository $activationTokenRepository */
        $activationTokenRepository = $this->getRepository(ActivationTokenEntity::class);

        /** @var DataService $translationsFromDb */
        $translationsFromDb = $this->getService('Translation\Data');

        // Change the user activation token and return the token activation entity
        $activationTokenEntity = $this->changeToken($activationTokenRepository, $userEntity);

        // Creating a task for the message sending queue
        $this->dispatchJob(UserRegisterTask::class, [
            'email'            => $userEntity->getEmail(),
            'activation-token' => $activationTokenEntity->getToken(),
            'subject'          => $translationsFromDb->getTranslationByKey('confirmRegistration')
        ]);

        return $this;

    }

    /**
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    final public function getResponse(): ResponseApiCollectorService
    {

        return $this->createApiResponse(200, 'register@successRegister');

    }

    /**
     * @param ActivationTokenRepository $activationTokenRepository
     * @param UserEntity                $userEntity
     *
     * @return ActivationTokenEntity
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function changeToken(ActivationTokenRepository $activationTokenRepository, UserEntity $userEntity): ActivationTokenEntity
    {

        /** @var ActivationTokenService $activationTokenService */
        $activationToken = $this->get('activation-token');

        $activationTokenEntity = new ActivationTokenEntity();
        $activationTokenEntity->setToken($activationToken->encode());

        // Updating a token in the table of all activation tokens
        $activationTokenRepository->update([
            'token' => $activationTokenEntity->getToken()
        ], [
            'user_id' => $userEntity->getId()
        ]);

        return $activationTokenEntity;

    }

}