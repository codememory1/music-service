<?php

namespace App\Service\ArtistSubscriber;

use App\Entity\User;
use App\Rest\ApiService;
use App\Rest\Http\Response;

/**
 * Class Subscribe.
 *
 * @package App\Service\ArtistSubscriber
 *
 * @author  Codememory
 */
class Subscribe extends ApiService
{
    public function subscribe(User $user, int $artistId): Response
    {
    }
}