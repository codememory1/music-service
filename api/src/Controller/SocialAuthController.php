<?php

namespace App\Controller;

use App\DTO\SocialAuthDTO;
use App\Rest\ApiController;
use App\Security\Auth\Authorization;
use App\Security\SocialAuth\GoogleAuth;
use App\Service\Google\GoogleOAuthClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SocialAuthController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/social')]
class SocialAuthController extends ApiController
{
    /**
     * @param GoogleOAuthClient $googleOAuthClient
     *
     * @return JsonResponse
     */
    #[Route('/google/auth-url', methods: 'GET')]
    public function googleAuthLink(GoogleOAuthClient $googleOAuthClient): JsonResponse
    {
        return $this->responseCollection->dataOutput([
            'url' => $googleOAuthClient->getUrlGenerator()->generateAuthUrl()
        ])->getResponse()->make();
    }

    /**
     * @param SocialAuthDTO $socialAuthDTO
     * @param GoogleAuth    $googleAuth
     * @param Authorization $authorization
     *
     * @return JsonResponse
     */
    #[Route('/google/auth', methods: 'POST')]
    public function googleAuth(SocialAuthDTO $socialAuthDTO, GoogleAuth $googleAuth, Authorization $authorization): JsonResponse
    {
        $authorizationToken = $googleAuth->make($socialAuthDTO->code);

        return $authorization->successAuthResponse([
            'access_token' => $authorizationToken->getAccessToken(),
            'refresh_token' => $authorizationToken->getRefreshToken()
        ])->make();
    }
}