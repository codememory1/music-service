<?php

namespace App\Service\UserSession;

use App\Dto\Transfer\RefreshTokenDto;
use App\Entity\UserSession;
use App\Rest\Http\Exceptions\FailedException;
use App\Security\Auth\AuthorizationToken;
use App\Service\AbstractService;
use DateTimeImmutable;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class UpdateAccessTokenService extends AbstractService
{
    #[Required]
    public ?AuthorizationToken $authorizationToken = null;

    #[ArrayShape([
        'access_token' => 'null|string',
        'refresh_token' => 'null|string'
    ])]
    public function update(RefreshTokenDto $refreshTokenDto): array
    {
        $this->validate($refreshTokenDto);

        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $finedUserSession = $userSessionRepository->findByRefreshToken($refreshTokenDto->refreshToken);

        if (null === $finedUserSession) {
            throw FailedException::failedToUpdateAccessToken();
        }

        $this->updateToken($finedUserSession);

        return [
            'access_token' => $this->authorizationToken->getAccessToken(),
            'refresh_token' => $this->authorizationToken->getRefreshToken(),
        ];
    }

    public function request(RefreshTokenDto $refreshTokenDto): JsonResponse
    {
        $tokens = $this->update($refreshTokenDto);

        return $this->responseCollection->successUpdate('token@successUpdate', $tokens);
    }

    private function updateToken(UserSession $userSession): void
    {
        $this->authorizationToken->generateAccessToken($userSession->getUser());
        $this->authorizationToken->generateRefreshToken($userSession->getUser());

        $userSession->setAccessToken($this->authorizationToken->getAccessToken());
        $userSession->setRefreshToken($this->authorizationToken->getRefreshToken());
        $userSession->setLastActivity(new DateTimeImmutable());

        $this->flusherService->save();
    }
}