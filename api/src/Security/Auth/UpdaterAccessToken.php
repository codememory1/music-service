<?php

namespace App\Security\Auth;

use App\DTO\TokenAuthenticatorDTO;
use App\Repository\UserRepository;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdaterAccessToken.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class UpdaterAccessToken extends AbstractSecurity
{
    /**
     * @var null|UserRepository
     */
    private ?UserRepository $userRepository = null;

    /**
     * @var null|TokenAuthenticator
     */
    private ?TokenAuthenticator $tokenAuthenticator = null;

    /**
     * @param UserRepository $userRepository
     *
     * @return $this
     */
    #[Required]
    public function setUserRepository(UserRepository $userRepository): self
    {
        $this->userRepository = $userRepository;

        return $this;
    }

    /**
     * @param TokenAuthenticator $tokenAuthenticator
     *
     * @return $this
     */
    #[Required]
    public function setTokenAuthenticator(TokenAuthenticator $tokenAuthenticator): self
    {
        $this->tokenAuthenticator = $tokenAuthenticator;

        return $this;
    }

    /**
     * @param TokenAuthenticatorDTO $updateAccessTokenDTO
     *
     * @return array
     */
    #[ArrayShape([
        'access_token' => 'string',
        'refresh_token' => 'string'
    ])]
    public function update(TokenAuthenticatorDTO $updateAccessTokenDTO): array
    {
        $user = $this->userRepository->getUserByRefreshToken($updateAccessTokenDTO->getRefreshToken());

        return $this->tokenAuthenticator->generateTokens($user);
    }

    /**
     * @param TokenAuthenticatorDTO $tokenAuthenticatorDTO
     *
     * @return bool|Response
     */
    public function isValidRefreshToken(TokenAuthenticatorDTO $tokenAuthenticatorDTO): Response|bool
    {
        if (null === $this->userRepository->getUserByRefreshToken($tokenAuthenticatorDTO->getRefreshToken())) {
            return $this->responseCollection
                ->notValid('common@invalidRefreshToken')
                ->getResponse();
        }

        return true;
    }

    /**
     * @param array $tokens
     *
     * @return Response
     */
    public function successUpdateToken(array $tokens): Response
    {
        $this->responseCollection->successUpdate('common@successUpdateAccessToken');
        $this->responseCollection->apiResponseSchema->setData([
            'tokens' => $tokens
        ]);

        return $this->responseCollection->getResponse();
    }
}