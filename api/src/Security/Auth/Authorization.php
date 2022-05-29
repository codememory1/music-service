<?php

namespace App\Security\Auth;

use App\Entity\User;
use App\Enum\EventEnum;
use App\Event\UserAuthorizationEvent;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Authorization.
 *
 * @package App\Security\Auth
 *
 * @author  Сodememory
 */
class Authorization extends AbstractService
{
    #[Required]
    public ?AuthorizationToken $authorizationToken = null;

    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    /**
     * @param User $authenticatedUser
     *
     * @return JsonResponse
     */
    public function auth(User $authenticatedUser): JsonResponse
    {
        $accessToken = $this->authorizationToken->generateAccessToken($authenticatedUser)->getAccessToken();
        $refreshToken = $this->authorizationToken->generateRefreshToken($authenticatedUser)->getRefreshToken();

        $this->eventDispatcher->dispatch(new UserAuthorizationEvent(
            $authenticatedUser,
            $this->authorizationToken
        ), EventEnum::AUTHORIZATION->value);

        return $this->responseCollection->successAuthorization([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ]);
    }
}