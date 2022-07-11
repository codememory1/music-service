<?php

namespace App\Service\UserSession;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Service\IPGeolocation\IPApi\Client;
use Jenssegers\Agent\Agent;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class CollectorSessionService.
 *
 * @package App\Service\UserSession
 *
 * @author  Codememory
 */
class CollectorSessionService
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function collect(UserDTO $userDTO, User $user, UserSessionTypeEnum $type, ?UserSession $userSessionEntity = null): UserSession
    {
        $agent = new Agent();
        $userSessionEntity ??= new UserSession();
        $ipResponse = $this->client->request($userDTO->ip)->response();

        $userSessionEntity->setUser($user);
        $userSessionEntity->setType($type);
        $userSessionEntity->setBrowser($agent->browser());
        $userSessionEntity->setIp($userDTO->ip);
        $userSessionEntity->setDevice($agent->device());
        $userSessionEntity->setOperatingSystem($agent->platform());

        $userSessionEntity->setContinent($ipResponse->getContinent());
        $userSessionEntity->setCity($ipResponse->getCity());
        $userSessionEntity->setCountry($ipResponse->getCountry());
        $userSessionEntity->setCountryCode($ipResponse->getCountryCode());
        $userSessionEntity->setRegion($ipResponse->getRegion());
        $userSessionEntity->setRegionName($ipResponse->getRegionName());
        $userSessionEntity->setTimezone($ipResponse->getTimezone());
        $userSessionEntity->setCurrency($ipResponse->getCurrency());
        $userSessionEntity->setCoordinates([
            'latitude' => $ipResponse->getLat(),
            'longitude' => $ipResponse->getLon()
        ]);

        return $userSessionEntity;
    }
}