<?php

namespace App\Service\Security\Auth;

use App\Entity\User;
use App\Entity\UserSession;
use App\Service\AbstractApiService;
use App\Service\JwtTokenGenerator;
use Codememory\Components\GEO\Geolocation;
use Codememory\Components\GEO\Interfaces\LocationInterface;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreatorUserSessionService
 *
 * @package App\Service\Security\Auth
 *
 * @author  codememory
 */
class CreatorUserSessionService extends AbstractApiService
{

    /**
     * @var Geolocation
     */
    private Geolocation $geo;

    /**
     * @var LocationInterface
     */
    private LocationInterface $location;

    /**
     * @var string|null
     */
    private ?string $accessToken = null;

    /**
     * @var string|null
     */
    private ?string $refreshToken = null;

    /**
     * @param Request         $request
     * @param Response        $response
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(Request $request, Response $response, ManagerRegistry $managerRegistry)
    {

        parent::__construct($request, $response, $managerRegistry);

        $this->geo = (new Geolocation())->setIp($request->getClientIp());
        $this->location = $this->geo->getLocation();

    }

    /**
     * @param User $user
     *
     * @return CreatorUserSessionService
     */
    public function create(User $user): CreatorUserSessionService
    {

        $jwtTokenGenerator = new JwtTokenGenerator();
        $userSessionEntity = new UserSession();

        // Saving generated tokens
        $this->accessToken = $this->generateAccessToken($jwtTokenGenerator, $user);
        $this->refreshToken = $this->generateAccessToken($jwtTokenGenerator, $user);

        $userSessionEntity
            ->setUser($user)
            ->setRefreshToken($this->refreshToken)
            ->setIp($this->request->getClientIp())
            ->setValid($_ENV['JWT_REFRESH_TTL']);

        // If there is information on this ip, fix it
        if ($this->geo->isSuccess()) {
            $userSessionEntity
                ->setCountry($this->location->getCountry()->getName())
                ->setCountryCode($this->location->getCountry()->getCode())
                ->setRegion($this->location->getRegion()->getName())
                ->setCity($this->location->getCity()->getName())
                ->setLatitude($this->location->getCity()->getLatitude())
                ->setLongitude($this->location->getCity()->getLongitude());
        }

        $this->em->persist($userSessionEntity);
        $this->em->flush();

        return $this;

    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {

        return $this->accessToken;

    }

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {

        return $this->refreshToken;

    }

    /**
     * @param JwtTokenGenerator $generator
     * @param User              $user
     *
     * @return string
     */
    private function generateAccessToken(JwtTokenGenerator $generator, User $user): string
    {

        return $generator->encode(
            $this->getUserSchema($user),
            $_ENV['JWT_ACCESS_PRIVATE_KEY'],
            $_ENV['JWT_ACCESS_TTL']
        );

    }

    /**
     * @param JwtTokenGenerator $generator
     * @param User              $user
     *
     * @return string
     */
    private function generateRefreshToken(JwtTokenGenerator $generator, User $user): string
    {

        return $generator->encode(
            $this->getUserSchema($user),
            $_ENV['JWT_REFRESH_PRIVATE_KEY'],
            $_ENV['JWT_REFRESH_TTL']
        );

    }

    /**
     * @param User $user
     *
     * @return array
     */
    #[ArrayShape([
        'id'      => "int|null",
        'email'   => "null|string",
        'profile' => "array",
    ])]
    private function getUserSchema(User $user): array
    {

        $userProfile = $user->getUserProfile();
        $profileSchema = [];

        if (null !== $userProfile) {
            $profileSchema = [
                'name'       => $userProfile->getName(),
                'surname'    => $userProfile->getSurname(),
                'patronymic' => $userProfile->getPatronymic(),
                'birth'      => $userProfile->getBirth()
            ];
        }

        return [
            'id'      => $user->getId(),
            'email'   => $user->getEmail(),
            'profile' => $profileSchema
        ];

    }

}