<?php

namespace App\Security\Session;

use App\Entity\UserSession;
use App\Repository\UserSessionRepository;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;

/**
 * Class DeleterSession.
 *
 * @package App\Security\Session
 *
 * @author  Codememory
 */
class DeleterSession extends AbstractSecurity
{
    /**
     * @param string $refreshToken
     *
     * @return UserSession
     */
    public function delete(string $refreshToken): Response
    {
        /** @var UserSessionRepository $userSessionRepository */
        $userSessionRepository = $this->em->getRepository(UserSession::class);

        $finedSession = $userSessionRepository->findOneBy(['refresh_token' => $refreshToken]);

        $this->em->remove($finedSession);
        $this->em->flush();

        return $finedSession;
    }
}