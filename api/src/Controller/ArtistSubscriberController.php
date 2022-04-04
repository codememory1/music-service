<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Rest\ApiController;
use App\Security\TokenAuthenticator;
use App\Service\ArtistSubscriber\Subscribe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArtistSubscriberController.
 *
 * @package App\Controller
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
        return $subscribeService->subscribe($authenticator->getUser(), $artistId)->make();
    }

    #[Route('/unsubscribe/{artistId<\d+>}', methods: 'GET')]
    #[Auth]
    public function unsubscribe(int $artistId): JsonResponse
    {
        return new JsonResponse();
    }
}