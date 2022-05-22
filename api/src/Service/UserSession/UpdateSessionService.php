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
    /**
     * @var CollectorSessionService
     */
    private CollectorSessionService $collectorSessionService;

    /**
     * @param CollectorSessionService $collectorSessionService
     *
     * @return void
     */
    #[Required]
    public function setCollectorSessionService(CollectorSessionService $collectorSessionService): void
    {
        $this->collectorSessionService = $collectorSessionService;
    }

    /**
     * @param UserDTO             $userDTO
     * @param User                $user
     * @param UserSessionTypeEnum $type
     *
     * @return UserSession
     */
    public function make(UserDTO $userDTO, UserSession $userSession, UserSessionTypeEnum $type): UserSession
    {
        $collectedUserSessionEntity = $this->collectorSessionService->collect(
            $userDTO,
            $userSession->getUser(),
            $type,
            $userSession
        );

        $this->em->flush();

        return $collectedUserSessionEntity;
    }
}