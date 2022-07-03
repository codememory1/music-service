<?php

namespace App\Service\UserSession;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Service\AbstractService;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateSessionService.
 *
 * @package App\Service\UserSession
 *
 * @author  Codememory
 */
class UpdateSessionService extends AbstractService
{
    #[Required]
    public ?CollectorSessionService $collectorSessionService = null;

    public function make(UserDTO $userDTO, User $user, ?UserSession $userSession = null, UserSessionTypeEnum $type = UserSessionTypeEnum::TEMP): UserSession
    {
        $collectedUserSessionEntity = $this->collectorSessionService->collect(
            $userDTO,
            $user,
            $type,
            $userSession
        );

        if (null === $collectedUserSessionEntity->getId()) {
            $this->em->persist($collectedUserSessionEntity);
        }

        $this->em->flush();

        return $collectedUserSessionEntity;
    }
}