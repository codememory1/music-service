<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Security\Session\CreatorSession;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class Authorization.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class Authorization extends AbstractSecurity
{

    /**
     * @param User             $identifiedUser
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return Response
     */
    #[ArrayShape([
        'access_token' => 'string',
        'refresh_token' => 'string'
    ])]
    public function auth(User $identifiedUser, AuthorizationDTO $authorizationDTO): Response
    {
        $creatorSession = new CreatorSession($this->em, $this->responseCollection);

        return $this->responseCollection
            ->successAuth($creatorSession->create($identifiedUser, $authorizationDTO))
            ->getResponse();
    }
}