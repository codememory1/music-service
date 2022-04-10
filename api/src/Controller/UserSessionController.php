<?php

namespace App\Controller;

use App\DTO\TokenAuthenticatorDTO;
use App\Rest\ApiController;
use App\Rest\Http\Response;
use App\Rest\Validator\Validator;
use App\Security\Auth\UpdaterAccessToken;
use App\Security\Session\DeleterSession;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserSessionController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/user/session')]
class UserSessionController extends ApiController
{
    /**
     * @param TokenAuthenticatorDTO $tokenAuthenticatorDTO
     * @param UpdaterAccessToken    $updaterAccessToken
     *
     * @return JsonResponse
     */
    #[Route('/access-token/update', methods: 'PUT')]
    public function updateAccessToken(TokenAuthenticatorDTO $tokenAuthenticatorDTO, UpdaterAccessToken $updaterAccessToken): JsonResponse
    {
        // Checking the validity of the refresh token
        $refreshTokenValidResponse = $updaterAccessToken->isValidRefreshToken($tokenAuthenticatorDTO);

        if ($refreshTokenValidResponse instanceof Response) {
            return $refreshTokenValidResponse->make();
        }

        $tokens = $updaterAccessToken->update($tokenAuthenticatorDTO);

        return $updaterAccessToken->successUpdateToken($tokens)->make();
    }

    #[Route('/delete/{id<\d+>}', methods: 'DELETE')]
    public function delete(
        Validator $validator,
        TokenAuthenticatorDTO $tokenAuthenticatorDTO,
        DeleterSession $deleterSession,
        int $id
    ): JsonResponse {
    }
}