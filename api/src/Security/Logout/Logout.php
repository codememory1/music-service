<?php

namespace App\Security\Logout;

use App\Dto\Transfer\RefreshTokenDto;
use App\Entity\UserSession;
use App\Rest\Http\Exceptions\FailedException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Logout.
 *
 * @package App\Security\Logout
 *
 * @author  Codememory
 */
class Logout extends AbstractService
{
    public function logout(RefreshTokenDto $refreshTokenDto): JsonResponse
    {
        $this->validate($refreshTokenDto);

        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $finedUserSession = $userSessionRepository->findByRefreshToken($refreshTokenDto->refreshToken);

        if (null === $finedUserSession) {
            throw FailedException::failedToLogout();
        }

        $this->flusherService->remove($finedUserSession);

        return $this->responseCollection->successLogout();
    }
}