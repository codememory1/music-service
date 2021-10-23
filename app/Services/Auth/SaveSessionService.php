<?php

namespace App\Services\Auth;

use App\Orm\Entities\UserEntity;
use App\Orm\Entities\UserSessionEntity;
use App\Orm\Repositories\UserSessionRepository;
use App\Services\AbstractApiService;
use App\Services\Tokens\SessionTokenService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\GEO\Geolocation;
use ReflectionException;

/**
 * Class SaveSessionService
 *
 * @package App\Services\Auth
 *
 * @author  Danil
 */
class SaveSessionService extends AbstractApiService
{

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserEntity             $userEntity
     * @param string                 $refreshToken
     *
     * @return void
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function save(EntityManagerInterface $entityManager, UserEntity $userEntity, string $refreshToken): void
    {

        /** @var UserSessionRepository $userSessionRepository */
        $userSessionRepository = $entityManager->getRepository(UserSessionEntity::class);

        // Collecting UserSessionEntity with basic information
        $userSessionEntity = $this->getCollectedUserSessionEntity($userEntity, $refreshToken);

        // Add IP information to UserSessionEntity, if information exists for this IP
        $userSessionEntity = $this->addIpInfo($userSessionEntity);

        // We delete records from the table where the token lifetime has already expired
        $this->removeInvalidTokens($userSessionRepository);

        // We save information about authorization to the table
        $entityManager->commit($userSessionEntity)->flush();

    }

    /**
     * @param UserEntity $userEntity
     * @param string     $refreshToken
     *
     * @return UserSessionEntity
     */
    private function getCollectedUserSessionEntity(UserEntity $userEntity, string $refreshToken): UserSessionEntity
    {

        /** @var SessionTokenService $sessionToken */
        $sessionToken = $this->get('session-token');
        $refreshTokenValidTo = date('Y-m-d H:i:s', $sessionToken->decodeRefresh($refreshToken)->exp);

        $userSessionEntity = new UserSessionEntity();
        $userSessionEntity
            ->setUserId($userEntity->getId())
            ->setRefreshToken($refreshToken)
            ->setIp($this->request->getIp())
            ->setValidTo($refreshTokenValidTo);

        return $userSessionEntity;

    }

    /**
     * @param UserSessionEntity $userSessionEntity
     *
     * @return UserSessionEntity
     */
    private function addIpInfo(UserSessionEntity $userSessionEntity): UserSessionEntity
    {

        $geolocation = (new Geolocation())->setIp($this->request->getIp());

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

        return $userSessionEntity;

    }

    /**
     * @param UserSessionRepository $userSessionRepository
     *
     * @return void
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function removeInvalidTokens(UserSessionRepository $userSessionRepository): void
    {

        $userSessionRepository->deleteInvalidTokens();

    }

}