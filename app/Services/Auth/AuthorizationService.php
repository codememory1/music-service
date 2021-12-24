<?php

namespace App\Services\Auth;

use App\Orm\Dto\UserDto;
use App\Orm\Entities\UserEntity;
use App\Orm\Entities\UserSessionEntity;
use App\Orm\Repositories\UserRepository;
use App\Orm\Repositories\UserSessionRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\SessionTokenService;
use App\Validations\Security\AuthValidation;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\Pack\DatabasePack;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidatorManager;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use ReflectionException;

/**
 * Class AuthorizationService
 *
 * @package App\Services\Auth
 *
 * @author  Danil
 */
class AuthorizationService extends AbstractApiService
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param ServiceProviderInterface $serviceProvider
     * @param DatabasePack             $databasePack
     */
    public function __construct(ServiceProviderInterface $serviceProvider, DatabasePack $databasePack)
    {

        parent::__construct($serviceProvider, $databasePack);

        /** @var UserRepository $userRepository */
        $userRepository = $this->getRepository(UserEntity::class);
        $this->userRepository = $userRepository;

    }

    /**
     * @param ValidatorManager $validatorManager
     *
     * @return ResponseApiCollectorService
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function authorize(ValidatorManager $validatorManager): ResponseApiCollectorService
    {

        /** @var IdentificationService $identificationService */
        $identificationService = $this->getService('Auth\Identification');

        /** @var AuthenticationService $authenticationService */
        $authenticationService = $this->getService('Auth\Authentication');

        /** @var VerificationsService $verificationsService */
        $verificationsService = $this->getService('Auth\Verifications');

        $validationManager = $validatorManager->create(new AuthValidation(), $this->request->post()->all());

        // Fulfillment of authorization conditions and receipt of a response
        $responseAuthorizationConditions = $this->authorizationConditions(
            $validationManager,
            $identificationService,
            $verificationsService,
            $authenticationService
        );

        // If the conditions are not met, return his response
        if (false === $responseAuthorizationConditions instanceof UserEntity) {
            return $responseAuthorizationConditions;
        }

        // Identification, authentication and verification were successful
        // Save the session and return the response
        return $this->handlerAuthorize($responseAuthorizationConditions);

    }

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return UserEntity|bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    final public function isAuth(EntityManagerInterface $entityManager): UserEntity|bool
    {

        $authorizationHeader = $this->request->getHeader('Authorization');
        $accessToken = explode(' ', $authorizationHeader, 2)[1] ?? null;

        /** @var UserSessionRepository $userSessionRepository */
        $userSessionRepository = $this->getRepository(UserSessionEntity::class);
        $finedSessionByAccessToken = $userSessionRepository->findBy([
            'access_token' => $accessToken
        ]);

        /** @var SessionTokenService $sessionToken */
        $sessionToken = $this->get('session-token');

        if (!empty($accessToken) && $sessionToken->verifyAccess($accessToken) && [] !== $finedSessionByAccessToken) {
            /** @var UserRepository $userRepository */
            $userRepository = $entityManager->getRepository(UserEntity::class);
            $userDataFromAccessToken = $sessionToken->decodeAccess($accessToken);

            return $userRepository->findOne([
                'id' => $userDataFromAccessToken->id
            ]);
        }

        return false;

    }

    /**
     * @param ValidationManagerInterface $validationManager
     * @param IdentificationService      $identificationService
     * @param VerificationsService       $verificationsService
     * @param AuthenticationService      $authenticationService
     *
     * @return ResponseApiCollectorService|UserEntity
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function authorizationConditions(ValidationManagerInterface $validationManager, IdentificationService $identificationService, VerificationsService $verificationsService, AuthenticationService $authenticationService): ResponseApiCollectorService|UserEntity
    {

        // Input validation check
        if (false === $validationManager->isValidation()) {
            return $this->apiResponse->create(400, $validationManager->getErrors());
        }

        // We check the user's identification by the input email or username
        if (false === $identificationResponse = $identificationService->identify($this->userRepository)) {
            return $identificationService->getResponse();
        }

        // Checking the activation status of the identified user's account
        if (true !== $statusResponse = $verificationsService->statusVerification($identificationResponse)) {
            return $statusResponse;
        }

        // Checking the Authentication of an Authenticated User
        if (true !== $authenticationResponse = $authenticationService->authenticate($identificationResponse)) {
            return $authenticationResponse;
        }

        return $identificationResponse;

    }

    /**
     * @param UserEntity $userEntity
     *
     * @return ResponseApiCollectorService
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function handlerAuthorize(UserEntity $userEntity): ResponseApiCollectorService
    {

        /** @var SessionTokenService $sessionToken */
        $sessionToken = $this->get('session-token');
        [$accessToken, $refreshToken] = $sessionToken->generateTokens((new UserDto($userEntity))->getTransformedData());

        // Save the user's session
        $this->saveSessionAuth($userEntity, $accessToken, $refreshToken);

        return $this->createApiResponse(200, 'auth@successAuth', [
            'tokens' => [
                'access_token'  => $accessToken,
                'refresh_token' => $refreshToken
            ],
            'user_data' => (new UserDto($userEntity))->getTransformedData()
        ]);

    }

    /**
     * @param UserEntity $userEntity
     * @param string     $accessToken
     * @param string     $refreshToken
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function saveSessionAuth(UserEntity $userEntity, string $accessToken, string $refreshToken): void
    {

        /** @var SaveSessionService $saveSessionService */
        $saveSessionService = $this->getService('Auth\SaveSession');

        $saveSessionService->save($userEntity, $accessToken, $refreshToken);

    }

}