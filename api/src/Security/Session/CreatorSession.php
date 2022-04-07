<?php

namespace App\Security\Session;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Entity\UserSession;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Service\JwtTokenGenerator;
use Codememory\Components\GEO\Geolocation;
use Jenssegers\Agent\Agent;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreatorSession.
 *
 * @package App\Security\Session
 *
 * @author  Codememory
 */
class CreatorSession extends AbstractSecurity
{
    /**
     * @var null|JwtTokenGenerator
     */
    private ?JwtTokenGenerator $jwtTokenGenerator = null;

    /**
     * @param JwtTokenGenerator $jwtTokenGenerator
     *
     * @return $this
     */
    #[Required]
    public function setJwtTokenGenerator(JwtTokenGenerator $jwtTokenGenerator): self
    {
        $this->jwtTokenGenerator = $jwtTokenGenerator;

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
        $generatedTokens = $this->generateTokens($identifiedUser);

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
        return $this->responseCollection->successCreate('userSession@successCreate')->getResponse();
    }

    /**
     * @param User $user
     *
     * @return array
     */
    #[ArrayShape([
        'access_token' => 'string',
        'refresh_token' => 'string'
    ])]
    private function generateTokens(User $user): array
    {
        return [
            'access_token' => $this->generateAccessToken($user),
            'refresh_token' => $this->generateRefreshToken($user)
        ];
    }

    /**
     * @param User $user
     *
     * @return string
     */
    private function generateAccessToken(User $user): string
    {
        return $this->jwtTokenGenerator->encode(
            $this->tokenSchema($user),
            'JWT_ACCESS_PRIVATE_KEY',
            'JWT_ACCESS_TTL'
        );
    }

    /**
     * @param User $identifiedUser
     *
     * @return array
     */
    #[ArrayShape([
        'id' => 'int|null',
        'email' => 'null|string'
    ])]
    private function tokenSchema(User $identifiedUser): array
    {
        return [
            'id' => $identifiedUser->getId(),
            'email' => $identifiedUser->getEmail()
        ];
    }

    /**
     * @param User $user
     *
     * @return string
     */
    private function generateRefreshToken(User $user): string
    {
        return $this->jwtTokenGenerator->encode(
            $this->tokenSchema($user),
            'JWT_REFRESH_PRIVATE_KEY',
            'JWT_REFRESH_TTL'
        );
    }
}