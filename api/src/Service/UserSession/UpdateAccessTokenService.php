<?php

namespace App\Service\UserSession;

use App\DTO\AccessTokenDTO;
use App\Entity\UserSession;
use App\Rest\Http\Exceptions\InvalidException;
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
    /**
     * @var null|AuthorizationToken
     */
    private ?AuthorizationToken $authorizationToken = null;

    /**
     * @param AuthorizationToken $authorizationToken
     *
     * @return void
     */
    #[Required]
    public function setAuthorizationToken(AuthorizationToken $authorizationToken): void
    {
        $this->authorizationToken = $authorizationToken;
    }

    /**
     * @param AccessTokenDTO $accessTokenDTO
     *
     * @return JsonResponse
     */
    public function make(AccessTokenDTO $accessTokenDTO): JsonResponse
    {
        if (false === $this->validate($accessTokenDTO)) {
            return $this->validator->getResponse();
        }

        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $finedUserSession = $userSessionRepository->findOneBy([
            'refreshToken' => $accessTokenDTO->refreshToken
        ]);

        if (null === $finedUserSession) {
            throw InvalidException::invalidRefreshToken();
        }

        $this->updateToken($finedUserSession);

        return $this->responseCollection->successUpdate('token@successUpdate', [
            'access_token' => $this->authorizationToken->getAccessToken(),
            'refresh_token' => $this->authorizationToken->getRefreshToken(),
        ]);
    }

    /**
     * @param UserSession $userSession
     *
     * @return void
     */
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