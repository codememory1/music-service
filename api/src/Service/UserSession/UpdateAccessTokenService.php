<?php

namespace App\Service\UserSession;

use App\DTO\RefreshTokenDTO;
use App\Entity\UserSession;
use App\Rest\Http\Exceptions\FailedException;
use App\Security\Auth\AuthorizationToken;
use App\Service\AbstractService;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateAccessTokenService.
 *
 * @package App\Service\UserSession
 *
 * @author  Codememory
 */
class UpdateAccessTokenService extends AbstractService
{
    #[Required]
    public ?AuthorizationToken $authorizationToken = null;

    public function make(RefreshTokenDTO $refreshTokenDTO): JsonResponse
    {
        if (false === $this->validate($refreshTokenDTO)) {
            return $this->validator->getResponse();
        }

        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $finedUserSession = $userSessionRepository->findOneBy([
            'refreshToken' => $refreshTokenDTO->refreshToken
        ]);

        if (null === $finedUserSession) {
            throw FailedException::failedToUpdateAccessToken();
        }

        $this->updateToken($finedUserSession);

        return $this->responseCollection->successUpdate('token@successUpdate', [
            'access_token' => $this->authorizationToken->getAccessToken(),
            'refresh_token' => $this->authorizationToken->getRefreshToken(),
        ]);
    }

    private function updateToken(UserSession $userSession): void
    {
        $this->authorizationToken->generateAccessToken($userSession->getUser());
        $this->authorizationToken->generateRefreshToken($userSession->getUser());

        $userSession->setAccessToken($this->authorizationToken->getAccessToken());
        $userSession->setRefreshToken($this->authorizationToken->getRefreshToken());
        $userSession->setLastActivity(new DateTimeImmutable());

        $this->em->flush();
    }
}