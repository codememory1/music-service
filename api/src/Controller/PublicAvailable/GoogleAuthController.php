<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Dto\Transformer\GoogleAuthTransformer;
use App\Rest\Controller\AbstractRestController;
use App\Security\ServiceAuth\GoogleAuthorization;
use App\Service\Platform\Google\Client;
use App\Service\Platform\Google\Client as GoogleClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/google')]
#[Authorization(false)]
class GoogleAuthController extends AbstractRestController
{
    #[Route('/authorization-url', methods: Request::METHOD_GET)]
    public function authorizationUrl(GoogleClient $client): JsonResponse
    {
        return $this->response([
            'url' => $client->createAuthorizationUrl()
        ]);
    }

    #[Route('/auth', methods: Request::METHOD_POST)]
    public function auth(Client $client, GoogleAuthTransformer $googleAuthTransformer, GoogleAuthorization $googleAuthorization): JsonResponse
    {
        return $this->response($googleAuthorization->make($client, $googleAuthTransformer->transformFromRequest()));
    }
}