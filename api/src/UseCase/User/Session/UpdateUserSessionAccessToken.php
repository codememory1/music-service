<?php

namespace App\UseCase\User\Session;

use App\Dto\Transfer\RefreshTokenDto;
use App\Entity\UserSession;
use App\Exception\Http\FailedException;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Repository\UserSessionRepository;
use App\Security\Auth\AuthorizationToken;
use DateTimeImmutable;
use JetBrains\PhpStorm\ArrayShape;

final class UpdateUserSessionAccessToken
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly UserSessionRepository $userSessionRepository,
        private readonly AuthorizationToken $authorizationToken
    ) {
    }

    #[ArrayShape([
        'access_token' => 'null|string',
        'refresh_token' => 'null|string'
    ])]
    public function process(RefreshTokenDto $dto): array
    {
        $this->validator->validate($dto);

        $userSession = $this->userSessionRepository->findByRefreshToken($dto->refreshToken);

        if (null === $userSession) {
            throw FailedException::failedToUpdateAccessToken();
        }

        $this->updateToken($userSession);

        return [
            'access_token' => $this->authorizationToken->getAccessToken(),
            'refresh_token' => $this->authorizationToken->getRefreshToken(),
        ];
    }

    private function updateToken(UserSession $userSession): void
    {
        $this->authorizationToken->generateAccessToken($userSession->getUser());
        $this->authorizationToken->generateRefreshToken($userSession->getUser());

        $userSession->setAccessToken($this->authorizationToken->getAccessToken());
        $userSession->setRefreshToken($this->authorizationToken->getRefreshToken());
        $userSession->setLastActivity(new DateTimeImmutable());

        $this->flusher->save();
    }
}