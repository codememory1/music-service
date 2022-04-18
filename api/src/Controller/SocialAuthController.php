<?php

namespace App\Controller;

use App\Rest\ApiController;
use App\Service\Google\GoogleOAuthClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SocialAuthController
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
}