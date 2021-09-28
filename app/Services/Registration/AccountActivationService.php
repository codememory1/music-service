<?php

namespace App\Services\Registration;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UsersRepository;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\ActivationTokenService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\Services\AbstractService;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use ReflectionException;

/**
 * Class AccountActivationService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class AccountActivationService extends AbstractService
{

    /**
     * @var ResponseApiCollectorService
     */
    private ResponseApiCollectorService $apiResponse;

    /**
     * @var TranslationInterface
     */
    private TranslationInterface $translation;

    /**
     * @param ServiceProviderInterface $serviceProvider
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var ResponseApiCollectorService $apiResponse */
        $apiResponse = $this->get('api-response');
        $this->apiResponse = $apiResponse;

        /** @var TranslationInterface $translation */
        $translation = $this->get('translator');
        $this->translation = $translation;

    }

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

        /** @var UsersRepository $userRepository */
        $userRepository = $entityManager->getRepository(UserEntity::class);

        /** @var ActivationTokenService $activationToken */
        $activationToken = $this->get('activation-token');
        $finedUserByToken = $userRepository->findOne([
            'activation_token' => $token,
            'status'           => 0
        ]);

        // Check the token for validity and existence in the database
        if (!$activationToken->verify($token) || false === $finedUserByToken) {
            return $this->apiResponse->create(400, [
                $this->translation->getTranslationActiveLang('register.invalidTokenActivation')
            ]);
        }

        // The token is valid and was found in the database
        // We activate a user account with this token
        return $this->activationHandler($userRepository, $finedUserByToken);

    }

    /**
     * @param UsersRepository $usersRepository
     * @param UserEntity      $userEntity
     *
     * @return ResponseApiCollectorService
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     */
    private function activationHandler(UsersRepository $usersRepository, UserEntity $userEntity): ResponseApiCollectorService
    {

        // Updating user data
        $usersRepository->update([
            'status'           => 1,
            'activation_token' => ''
        ], $userEntity->getEmail());

        return $this->apiResponse->create(200, [
            $this->translation->getTranslationActiveLang('register.successAccountActivate')
        ]);

    }

}