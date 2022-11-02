<?php

namespace App\Service\UserSession;

use App\Dto\Transfer\UserDto;
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

class CollectorSessionService
{
    public function __construct(
        private readonly Client $client
    ) {}

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function collect(UserDto $userDto, User $user, UserSessionTypeEnum $type, ?UserSession $userSession = null): UserSession
    {
        $userSession ??= new UserSession();
        $ipResponse = $this->client->request($userDto->ip)->response();

        $this->setAgent($userSession);

        $userSession->setUser($user);
        $userSession->setType($type);
        $userSession->setIp($userDto->ip);

        $userSession->setContinent($ipResponse->getContinent());
        $userSession->setCity($ipResponse->getCity());
        $userSession->setCountry($ipResponse->getCountry());
        $userSession->setCountryCode($ipResponse->getCountryCode());
        $userSession->setRegion($ipResponse->getRegion());
        $userSession->setRegionName($ipResponse->getRegionName());
        $userSession->setTimezone($ipResponse->getTimezone());
        $userSession->setCurrency($ipResponse->getCurrency());
        $userSession->setCoordinates([
            'latitude' => $ipResponse->getLat(),
            'longitude' => $ipResponse->getLon()
        ]);

        return $userSession;
    }

    private function setAgent(UserSession $userSession): void
    {
        $agent = new Agent();

        $userSession->setBrowser($agent->browser());
        $userSession->setDevice($agent->device());
        $userSession->setOperatingSystem($agent->platform());
    }
}