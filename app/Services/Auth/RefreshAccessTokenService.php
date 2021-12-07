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
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class RefreshAccessTokenService
 *
 * @package App\Services\Auth
 *
 * @author  Danil
 */
class RefreshAccessTokenService extends AbstractApiService
{

    /**
     * @param string $refreshToken
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     * @throws InvalidTimezoneException
     * @throws ServiceNotExistException
     */
    final public function refresh(string $refreshToken): ResponseApiCollectorService
    {

        /** @var SessionTokenService $sessionToken */
        $sessionToken = $this->get('session-token');

        // Checking token validation and session existence
        if (!$sessionToken->verifyRefresh($refreshToken) || !$finedUser = $this->getUserByRefreshToken($refreshToken)) {
            return $this->createApiResponse(400, 'common@invalidRefreshToken');
        }

        $userDto = new UserDto($finedUser);
        [$accessToken] = $sessionToken->generateTokens($userDto->getTransformedData());

        // We return the answer about the successful update of the token and the data itself
        return $this->createApiResponse(
            200,
            'refreshToken@successRefreshAccessToken',
            [
                'tokens'    => [
                    'access_token'  => $accessToken,
                    'refresh_token' => $refreshToken
                ],
                'user_data' => $userDto->getTransformedData()
            ]
        );

    }

    /**
     * @param string $refreshToken
     *
     * @return UserEntity|bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function getUserByRefreshToken(string $refreshToken): UserEntity|bool
    {

        /** @var UserSessionRepository $userSessionRepository */
        $userSessionRepository = $this->getRepository(UserSessionEntity::class);

        /** @var UserSessionEntity|bool $finedSession */
        $finedSession = $userSessionRepository->customFindBy([
            'refresh_token' => $refreshToken
        ])->entity()->first();

        if (false !== $finedSession) {
            /** @var UserRepository $userRepository */
            $userRepository = $this->getRepository(UserEntity::class);

            return $userRepository->findById($finedSession->getUserId());
        }

        return false;

    }

}