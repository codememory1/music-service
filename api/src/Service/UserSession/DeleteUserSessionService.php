<?php

namespace App\Service\UserSession;

use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteUserSessionService.
 *
 * @package App\Service\UserSession
 *
 * @author  Codememory
 */
class DeleteUserSessionService extends AbstractService
{
    public function make(UserSession $userSession): JsonResponse
    {
        if ($userSession->getType() !== UserSessionTypeEnum::TEMP->name) {
            throw EntityNotFoundException::userSession();
        }

        $this->em->remove($userSession);
        $this->em->flush();

        return $this->responseCollection->successDelete('userSession@successDelete');
    }

    public function deleteAll(User $toUser): JsonResponse
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $userSessions = $userSessionRepository->findBy([
            'user' => $toUser,
            'type' => UserSessionTypeEnum::TEMP->name
        ]);

        foreach ($userSessions as $userSession) {
            $this->em->remove($userSession);
        }

        $this->em->flush();

        return $this->responseCollection->successDelete('userSession@successDeleteMultiple');
    }
}