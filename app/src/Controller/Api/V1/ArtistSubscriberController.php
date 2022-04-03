<?php

namespace App\Controller\Api\V1;

use App\Annotation\Auth;
use App\Controller\Api\ApiController;
use App\Security\TokenAuthenticator;
use App\Service\ArtistSubscriber\Subscribe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArtistSubscriberController.
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
#[Route('/artist')]
class ArtistSubscriberController extends ApiController
{
    #[Route('/subscribe/{artistId<\d+>}', methods: 'GET')]
    #[Auth]
    public function subscribe(TokenAuthenticator $authenticator, Subscribe $subscribeService, int $artistId): JsonResponse
    {
        return $subscribeService->subscribe($artistId, $authenticator)->make();
    }

    #[Route('/unsubscribe/{artistId<\d+>}', methods: 'GET')]
    #[Auth]
    public function unsubscribe(int $artistId): JsonResponse
    {
    }
}