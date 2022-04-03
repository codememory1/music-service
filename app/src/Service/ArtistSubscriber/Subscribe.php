<?php

namespace App\Service\ArtistSubscriber;

use App\Rest\ApiService;
use App\Rest\Http\Response;
use App\Security\TokenAuthenticator;

/**
 * Class Subscribe.
 *
 * @package App\Service\ArtistSubscriber
 *
 * @author  Codememory
 */
class Subscribe extends ApiService
{
    public function subscribe(TokenAuthenticator $authenticator, int $artistId): Response
    {
        $user = $authenticator->getUser();
    }
}