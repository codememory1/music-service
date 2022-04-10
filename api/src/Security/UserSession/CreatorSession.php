<?php

namespace App\Security\UserSession;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Entity\UserSession;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Security\Auth\TokenAuthenticator;
use Codememory\Components\GEO\Geolocation;
use Jenssegers\Agent\Agent;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreatorSession.
 *
 * @package App\Security\UserSession
 *
 * @author  Codememory
 */
class CreatorSession extends AbstractSecurity
{
    /**
     * @var null|TokenAuthenticator
     */
    private ?TokenAuthenticator $tokenAuthenticator = null;

    /**
     * @param TokenAuthenticator $tokenAuthenticator
     *
     * @return $this
     */
    #[Required]
    public function setTokenAuthenticator(TokenAuthenticator $tokenAuthenticator): self
    {
        $this->tokenAuthenticator = $tokenAuthenticator;

        return $this;
    }

    /**
     * @param User             $identifiedUser
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return array
     */
    #[ArrayShape([
        'access_token' => 'string',
        'refresh_token' => 'string'
    ])]
    public function create(User $identifiedUser, AuthorizationDTO $authorizationDTO): array
    {
        $geo = new Geolocation();
        $agent = new Agent();
        $userSessionEntity = new UserSession();
        $generatedTokens = $this->tokenAuthenticator->generateTokens($identifiedUser);

        $geo->setIp($authorizationDTO->clientIp);

        $userSessionEntity
            ->setUser($identifiedUser)
            ->setBrowser($agent->browser())
            ->setIp($authorizationDTO->clientIp)
            ->setDeviceModel($agent->device())
            ->setOperatingSystem($agent->platform())
            ->setRefreshToken($generatedTokens['refresh_token']);

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

        $this->em->persist($userSessionEntity);
        $this->em->flush();

        return $generatedTokens;
    }

    /**
     * @return Response
     */
    public function successCreateSessionResponse(): Response
    {
        return $this->responseCollection
            ->successCreate('userSession@successCreate')
            ->getResponse();
    }
}