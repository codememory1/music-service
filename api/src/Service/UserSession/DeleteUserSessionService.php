<?php

namespace App\Service\UserSession;

use App\Entity\User;
use App\Entity\UserSession;
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
    /**
     * @param UserSession $userSession
     *
     * @return JsonResponse
     */
    public function make(UserSession $userSession): JsonResponse
    {
        $this->em->remove($userSession);
        $this->em->flush();

        return $this->responseCollection->successDelete('userSession@successDelete');
    }

    /**
     * @param User $toUser
     *
     * @return JsonResponse
     */
    public function deleteAll(User $toUser): JsonResponse
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);

        foreach ($userSessionRepository->findBy(['user' => $toUser]) as $userSession) {
            $this->em->remove($userSession);
        }

        $this->em->flush();

        return $this->responseCollection->successDelete('userSession@successDeleteMultiple');
    }
}