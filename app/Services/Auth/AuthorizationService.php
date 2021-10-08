<?php

namespace App\Services\Auth;

use App\Orm\Dto\UserDto;
use App\Orm\Entities\UserEntity;
use App\Orm\Entities\UserSessionEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\SessionTokenService;
use App\Validations\AuthValidation;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\GEO\Geolocation;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidatorManager;
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
     * @param ValidatorManager       $validatorManager
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService
     * @throws InvalidTimezoneException
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    final public function authorize(ValidatorManager $validatorManager, EntityManagerInterface $entityManager): ResponseApiCollectorService
    {

        /** @var IdentificationService $identificationService */
        $identificationService = $this->getService('Auth\Identification');

        /** @var AuthenticationService $authenticationService */
        $authenticationService = $this->getService('Auth\Authentication');

        /** @var VerificationsService $verificationsService */
        $verificationsService = $this->getService('Auth\Verifications');

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(UserEntity::class);
        $validationManager = $validatorManager->create(new AuthValidation(), $this->request->post()->all());

        // Fulfillment of authorization conditions and receipt of a response
        $responseAuthorizationConditions = $this->authorizationConditions(
            $validationManager,
            $identificationService,
            $userRepository,
            $verificationsService,
            $authenticationService
        );

        // If the conditions are not met, return his response
        if (false === $responseAuthorizationConditions instanceof UserEntity) {
            return $responseAuthorizationConditions;
        }

        // Identification, authentication and verification were successful
        // Save the session and return the response
        return $this->handlerAuthorize($entityManager, $responseAuthorizationConditions);

    }

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return UserEntity|bool
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    final public function isAuth(EntityManagerInterface $entityManager): UserEntity|bool
    {

        $authorizationHeader = $this->request->getHeader('Authorization');
        $accessToken = explode(' ', $authorizationHeader, 2)[1] ?? null;

        /** @var SessionTokenService $sessionToken */
        $sessionToken = $this->get('session-token');

        if (!empty($accessToken) && $sessionToken->verifyAccess($accessToken)) {
            /** @var UserRepository $userRepository */
            $userRepository = $entityManager->getRepository(UserEntity::class);
            $userDataFromAccessToken = $sessionToken->decodeAccess($accessToken);

            return $userRepository->findOne([
                'userid' => $userDataFromAccessToken->userid
            ]);
        }

        return false;

    }

    /**
     * @param ValidationManagerInterface $validationManager
     * @param IdentificationService      $identificationService
     * @param UserRepository             $userRepository
     * @param VerificationsService       $verificationsService
     * @param AuthenticationService      $authenticationService
     *
     * @return ResponseApiCollectorService|UserEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function authorizationConditions(ValidationManagerInterface $validationManager, IdentificationService $identificationService, UserRepository $userRepository, VerificationsService $verificationsService, AuthenticationService $authenticationService): ResponseApiCollectorService|UserEntity
    {

        // Input validation check
        if (false === $validationManager->isValidation()) {
            return $this->apiResponse->create(400, $validationManager->getErrors());
        }

        // We check the user's identification by the input email or username
        if (false === $identificationResponse = $identificationService->identify($userRepository)) {
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
     * @param EntityManagerInterface $entityManager
     * @param UserEntity             $userEntity
     *
     * @return ResponseApiCollectorService
     * @throws InvalidTimezoneException
     */
    private function handlerAuthorize(EntityManagerInterface $entityManager, UserEntity $userEntity): ResponseApiCollectorService
    {

        /** @var SessionTokenService $sessionToken */
        $sessionToken = $this->get('session-token');
        [$accessToken, $refreshToken] = $sessionToken->generateTokens((new UserDto($userEntity))->getTransformedData());

        // Save the user's session
        $this->saveSession($entityManager, $sessionToken, $refreshToken);

        return $this->createApiResponse(200, 'auth.success', [
            'access_token'  => $accessToken,
            'refresh_token' => $refreshToken
        ]);

    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param SessionTokenService    $sessionToken
     * @param string                 $refreshToken
     *
     * @return void
     */
    private function saveSession(EntityManagerInterface $entityManager, SessionTokenService $sessionToken, string $refreshToken): void
    {

        $refreshTokenValidTo = date('Y-m-d H:i:s', $sessionToken->decodeRefresh($refreshToken)->exp);

        $geolocation = (new Geolocation())->setIp($this->request->getIp());
        $userSessionEntity = new UserSessionEntity();

        $userSessionEntity
            ->setRefreshToken($refreshToken)
            ->setIp($this->request->getIp())
            ->setValidTo($refreshTokenValidTo);

        // We set information about the ip address, if there is information for this ip
        if ($geolocation->isSuccess()) {
            $location = $geolocation->getLocation();
            $country = $location->getCountry();

            $userSessionEntity
                ->setCountry($country->getName())
                ->setCodeCountry($country->getCode())
                ->setRegion($location->getRegion()->getName())
                ->setCity($location->getCity()->getName())
                ->setLatitude($country->getLatitude())
                ->setLongitude($country->getLongitude());
        }

        $entityManager->commit($userSessionEntity)->flush();

    }

}