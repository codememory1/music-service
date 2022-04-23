<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class UserSessionRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|UserSession find($id, $lockMode = null, $lockVersion = null)
 * @method null|UserSession findOneBy(array $criteria, array $orderBy = null)
 * @method UserSession[]    findAll()
 * @method UserSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSessionRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSession::class);
    }

    /**
     * @param User $user
     *
     * @return null|UserSession
     */
    public function getRegistrationSession(User $user): ?UserSession
    {
        return $this->findOneBy([
            'user' => $user,
            'type' => UserSessionTypeEnum::REGISTRATION_SESSION->value
        ]);
    }

    /**
     * @param User $user
     *
     * @return null|UserSession
     */
    public function getLastTempSessionUser(User $user): ?UserSession
    {
        return $this->findOneBy([
            'user' => $user,
            'type' => UserSessionTypeEnum::TEMPORARY->value
        ], ['id' => 'DESC']);
    }

    /**
     * @param UserSession $userSession
     *
     * @return array
     */
    #[ArrayShape([
        'ip' => 'null|string',
        'country' => 'null|string',
        'country_code' => 'null|string',
        'region' => 'null|string',
        'city' => 'null|string',
        'device_model' => 'null|string',
        'operating_system' => 'null|string',
        'browser' => 'null|string'
    ])]
 public function getSessionToCompare(UserSession $userSession): array
 {
     return [
            'ip' => $userSession->getIp(),
            'country' => $userSession->getCountry(),
            'country_code' => $userSession->getCountryCode(),
            'region' => $userSession->getRegion(),
            'city' => $userSession->getCity(),
            'device_model' => $userSession->getDeviceModel(),
            'operating_system' => $userSession->getOperatingSystem(),
            'browser' => $userSession->getBrowser()
        ];
 }

    /**
     * @param User $user
     *
     * @return array
     */
    public function sessionDiffRelativeToRegistration(User $user): array
    {
        $registrationSession = $this->getRegistrationSession($user);
        $lastTempSession = $this->getLastTempSessionUser($user);

        if (null !== $registrationSession && null !== $lastTempSession) {
            return array_diff_assoc(
                $this->getSessionToCompare($lastTempSession),
                $this->getSessionToCompare($registrationSession)
            );
        }

        return [];
    }
}
