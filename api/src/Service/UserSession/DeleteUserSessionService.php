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

        $this->flusherService->addRemove($userSession)->save();

        return $this->responseCollection->successDelete('userSession@successDelete');
    }

    public function deleteAll(User $toUser): JsonResponse
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $userSessions = $userSessionRepository->findAllTemp($toUser);

        foreach ($userSessions as $userSession) {
            $this->flusherService->addRemove($userSession);
        }

        $this->flusherService->save();

        return $this->responseCollection->successDelete('userSession@successDeleteMultiple');
    }
}