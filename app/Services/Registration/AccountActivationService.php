<?php

namespace App\Services\Registration;

use App\Orm\Entities\ActivationTokenEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\ActivationTokenRepository;
use App\Orm\Repositories\Enums\StatusEnum;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\ActivationTokenService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class AccountActivationService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class AccountActivationService extends AbstractApiService
{

    /**
     * @param string $token
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function activate(string $token): ResponseApiCollectorService
    {

        /** @var ActivationTokenRepository $activationTokenRepository */
        $activationTokenRepository = $this->getRepository(ActivationTokenEntity::class);

        /** @var UserRepository $userRepository */
        $userRepository = $this->getRepository(UserEntity::class);

        /** @var ActivationTokenService $activationToken */
        $activationToken = $this->get('activation-token');

        // Search for a record by activation token
        $finedRecordByToken = $activationTokenRepository->findOne(['token' => $token]);

        // Check the token for validity and existence in the database
        if (!$activationToken->verify($token) || false === $finedRecordByToken) {
            return $this->createApiResponse(400, 'security@invalidTokenActivation');
        }

        // Search for a user by user_id from a found token record
        /** @var UserEntity $finedUserByToken */
        $finedUserByToken = $userRepository->findById($finedRecordByToken->getUserId());

        // The token is valid and was found in the database
        // We activate a user account with this token
        return $this->activationHandler($activationTokenRepository, $userRepository, $finedUserByToken);

    }

    /**
     * @param ActivationTokenRepository $activationTokenRepository
     * @param UserRepository            $userRepository
     * @param UserEntity                $userEntity
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     * @throws ServiceNotExistException
     */
    private function activationHandler(ActivationTokenRepository $activationTokenRepository, UserRepository $userRepository, UserEntity $userEntity): ResponseApiCollectorService
    {

        // Removing an activation token
        $this->deleteActivationToken($activationTokenRepository, $userEntity);

        // Account activation
        $this->changeStatus($userRepository, $userEntity);

        return $this->createApiResponse(200, 'security@successAccountActivation');

    }

    /**
     * @param ActivationTokenRepository $activationTokenRepository
     * @param UserEntity                $userEntity
     *
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function deleteActivationToken(ActivationTokenRepository $activationTokenRepository, UserEntity $userEntity): void
    {

        $activationTokenRepository->delete(['user_id' => $userEntity->getId()]);

    }

    /**
     * @param UserRepository $usersRepository
     * @param UserEntity     $userEntity
     *
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function changeStatus(UserRepository $usersRepository, UserEntity $userEntity): void
    {

        $usersRepository->update(['status' => StatusEnum::ACTIVATED], ['id' => $userEntity->getId()]);

    }

}