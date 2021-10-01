<?php

namespace App\Services\Registration;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\ActivationTokenService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
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
     * @param EntityManagerInterface $entityManager
     * @param string                 $token
     *
     * @return ResponseApiCollectorService
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    final public function activate(EntityManagerInterface $entityManager, string $token): ResponseApiCollectorService
    {

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(UserEntity::class);

        /** @var ActivationTokenService $activationToken */
        $activationToken = $this->get('activation-token');
        $finedUserByToken = $userRepository->findOne([
            'activation_token' => $token,
            'status'           => 0
        ]);

        // Check the token for validity and existence in the database
        if (!$activationToken->verify($token) || false === $finedUserByToken) {
            return $this->createApiResponse(400, 'register.invalidTokenActivation');
        }

        // The token is valid and was found in the database
        // We activate a user account with this token
        return $this->activationHandler($userRepository, $finedUserByToken);

    }

    /**
     * @param UserRepository $usersRepository
     * @param UserEntity     $userEntity
     *
     * @return ResponseApiCollectorService
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     */
    private function activationHandler(UserRepository $usersRepository, UserEntity $userEntity): ResponseApiCollectorService
    {

        // Updating user data
        $usersRepository->update([
            'status'           => 1,
            'activation_token' => ''
        ], $userEntity->getEmail());

        return $this->createApiResponse(200, 'register.successAccountActivate');

    }

}