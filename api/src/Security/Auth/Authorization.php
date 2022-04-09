<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Security\UserSession\CreatorSession;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Contracts\Service\Attribute\Required;

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
     * @var null|CreatorSession
     */
    private ?CreatorSession $creatorSession = null;

    /**
     * @param CreatorSession $creatorSession
     *
     * @return $this
     */
    #[Required]
    public function setCreatorSession(CreatorSession $creatorSession): self
    {
        $this->creatorSession = $creatorSession;

        return $this;
    }

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
        return $this->creatorSession->create($identifiedUser, $authorizationDTO);
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