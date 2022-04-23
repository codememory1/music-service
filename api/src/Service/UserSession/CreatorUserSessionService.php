<?php

namespace App\Service\UserSession;

use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Interfaces\AuthorizationTokenInterface;
use App\Rest\ApiService;
use Codememory\Components\GEO\Geolocation;
use Jenssegers\Agent\Agent;

/**
 * Class CreatorUserSessionService.
 *
 * @package App\Service\UserSession
 *
 * @author  Codememory
 */
class CreatorUserSessionService extends ApiService
{
    /**
     * @param User                        $user
     * @param AuthorizationTokenInterface $authorizationToken
     * @param string                      $clientIp
     *
     * @return UserSession
     */
    public function createTempSession(User $user, AuthorizationTokenInterface $authorizationToken, string $clientIp): UserSession
    {
        $preparedUserSession = $this->preparedUserSessionEntity($user, $clientIp);

        $preparedUserSession->setRefreshToken($authorizationToken->getRefreshToken());
        $preparedUserSession->setType(UserSessionTypeEnum::TEMPORARY);

        $this->em->persist($preparedUserSession);
        $this->em->flush();

        return $preparedUserSession;
    }

    /**
     * @param User                        $user
     * @param AuthorizationTokenInterface $authorizationToken
     * @param string                      $clientIp
     *
     * @return UserSession
     */
    public function createRegistrationSession(User $user, string $clientIp): UserSession
    {
        $preparedUserSession = $this->preparedUserSessionEntity($user, $clientIp);

        $preparedUserSession->setType(UserSessionTypeEnum::REGISTRATION_SESSION);
        $preparedUserSession->setRefreshToken(null);

        $this->em->persist($preparedUserSession);
        $this->em->flush();

        return $preparedUserSession;
    }

    /**
     * @param User                        $user
     * @param AuthorizationTokenInterface $authorizationToken
     * @param string                      $clientIp
     *
     * @return UserSession
     */
    public function preparedUserSessionEntity(User $user, string $clientIp): UserSession
    {
        $geo = new Geolocation();
        $agent = new Agent();
        $userSessionEntity = new UserSession();

        $geo->setIp($clientIp);

        $userSessionEntity
            ->setUser($user)
            ->setBrowser($agent->browser())
            ->setIp($clientIp)
            ->setDeviceModel($agent->device())
            ->setOperatingSystem($agent->platform());

        // Set info by IP
        if ($geo->isSuccess()) {
            $location = $geo->getLocation();
            $country = $location->getCountry();
            $city = $location->getCity();
            $region = $location->getRegion();

            $userSessionEntity
                ->setCountry($country->getName())
                ->setCountryCode($country->getCode())
                ->setLatitude($country->getLatitude())
                ->setLongitude($country->getLongitude())
                ->setCity($city->getName())
                ->setRegion($region->getName());
        }

        return $userSessionEntity;
    }
}