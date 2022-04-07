<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Rest\ApiController;
use App\Rest\Http\Response;
use App\Security\TokenAuthenticator;
use App\Service\ArtistSubscriber\Subscribe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArtistController
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/artist')]
class ArtistController extends ApiController
{

    /**
     * @param Subscribe          $subscribe
     * @param TokenAuthenticator $authenticator
     * @param int                $id
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/subscribe', methods: 'GET')]
    #[Auth]
    public function subscribe(Subscribe $subscribe, TokenAuthenticator $authenticator, int $id): JsonResponse
    {
        // Checking for the existence of an artist
        $finedArtist = $subscribe->existArtist($id);

        if($finedArtist instanceof Response) {
            return $finedArtist->make();
        }

        $responseSubscribed = $subscribe->subscribe($finedArtist, $authenticator->getUser());

        if($responseSubscribed instanceof Response) {
            return $responseSubscribed->make();
        }

        return $subscribe->successSubscribeResponse()->make();
    }
}