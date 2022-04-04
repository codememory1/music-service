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
     * @return array
     */
    #[ArrayShape([
        'access_token' => 'string',
        'refresh_token' => 'string'
    ])]
    public function auth(User $identifiedUser, AuthorizationDTO $authorizationDTO): array
    {
        $creatorSession = new CreatorSession($this->em, $this->responseCollection);

        return $creatorSession->create($identifiedUser, $authorizationDTO);
    }

    /**
     * @param array $tokens
     *
     * @return Response
     */
    public function successAuthResponse(array $tokens): Response
    {
        return $this->responseCollection->successAuth($tokens)->getResponse();
    }
}