<?php

namespace App\Security\Logout;

use App\DTO\RefreshTokenDTO;
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
    public function logout(RefreshTokenDTO $refreshTokenDTO): JsonResponse
    {
        if (false === $this->validate($refreshTokenDTO)) {
            return $this->validator->getResponse();
        }

        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $finedUserSession = $userSessionRepository->findOneBy([
            'refreshToken' => $refreshTokenDTO->refreshToken
        ]);

        if (null === $finedUserSession) {
            throw FailedException::failedToLogout();
        }

        $this->em->remove($finedUserSession);
        $this->em->flush();

        return $this->responseCollection->successLogout();
    }
}