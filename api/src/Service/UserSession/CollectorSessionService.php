<?php

namespace App\Service\UserSession;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use Codememory\Components\GEO\Geolocation;
use Jenssegers\Agent\Agent;

/**
 * Class CollectorSessionService.
 *
 * @package App\Service\UserSession
 *
 * @author  Codememory
 */
class CollectorSessionService
{
    /**
     * @param UserDTO             $userDTO
     * @param User                $user
     * @param UserSessionTypeEnum $type
     * @param null|UserSession    $userSession
     *
     * @return UserSession
     */
    public function collect(UserDTO $userDTO, User $user, UserSessionTypeEnum $type, ?UserSession $userSessionEntity = null): UserSession
    {
        $geo = new Geolocation();
        $agent = new Agent();
        $userSessionEntity ??= new UserSession();

        $geo->setIp($userDTO->ip);

        $userSessionEntity->setUser($user);
        $userSessionEntity->setType($type);
        $userSessionEntity->setBrowser($agent->browser());
        $userSessionEntity->setIp($userDTO->ip);
        $userSessionEntity->setDevice($agent->device());
        $userSessionEntity->setOperatingSystem($agent->platform());

        // Set info by IP
        if ($geo->isSuccess()) {
            $location = $geo->getLocation();
            $country = $location->getCountry();
            $city = $location->getCity();

            $userSessionEntity->setCountry($country->getName());
            $userSessionEntity->setCity($city->getName());
            $userSessionEntity->setCoordinates([
                'latitude' => $country->getLatitude(),
                'longitude' => $country->getLongitude()
            ]);
        }

        return $userSessionEntity;
    }
}