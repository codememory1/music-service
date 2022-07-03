<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\DTO\GoogleAuthDTO;
use App\Rest\Controller\AbstractRestController;
use App\Security\ServiceAuth\GoogleAuthorization;
use App\Service\Platform\Google\Client;
use App\Service\Platform\Google\Client as GoogleClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GoogleAuthController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/google')]
class GoogleAuthController extends AbstractRestController
{
    #[Route('/authorization-url', methods: 'GET')]
    #[Authorization(false)]
    public function authorizationUrl(GoogleClient $client): JsonResponse
    {
        return $this->responseCollection->dataOutput([
            'url' => $client->createAuthorizationUrl()
        ]);
    }

    #[Route('/auth', methods: 'POST')]
    #[Authorization(false)]
    public function auth(Client $client, GoogleAuthDTO $googleAuthDTO, GoogleAuthorization $googleAuthorization): JsonResponse
    {
        return $googleAuthorization->make($client, $googleAuthDTO->collect());
    }
}