<?php

namespace App\Service\UserSession;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Service\AbstractService;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreateSessionService.
 *
 * @package App\Service\UserSession
 *
 * @author  Codememory
 */
class CreateSessionService extends AbstractService
{
    #[Required]
    public ?CollectorSessionService $collectorSessionService = null;

    public function make(UserDTO $userDTO, User $user, UserSessionTypeEnum $type): UserSession
    {
        $collectedUserSessionEntity = $this->collectorSessionService->collect($userDTO, $user, $type);

        $this->em->persist($collectedUserSessionEntity);
        $this->em->flush();

        return $collectedUserSessionEntity;
    }
}