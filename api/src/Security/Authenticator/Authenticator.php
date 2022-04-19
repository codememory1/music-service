<?php

namespace App\Security\Authenticator;

use App\DTO\TokenAuthenticatorDTO;
use App\Entity\User;
use App\Enum\RolePermissionNameEnum;
use App\Repository\UserRepository;
use App\Rest\Http\ResponseCollection;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Authenticator.
 *
 * @package App\Security\Authenticator
 *
 * @author  Codememory
 */
class Authenticator
{
    /**
     * @var TokenAuthenticatorDTO
     */
    private TokenAuthenticatorDTO $tokenAuthenticatorDTO;

    /**
     * @var ResponseCollection
     */
    private ResponseCollection $responseCollection;

    /**
     * @var null|UserRepository
     */
    private ?UserRepository $userRepository = null;

    /**
     * @param TokenAuthenticatorDTO $tokenAuthenticatorDTO
     * @param ResponseCollection    $responseCollection
     */
    public function __construct(TokenAuthenticatorDTO $tokenAuthenticatorDTO, ResponseCollection $responseCollection)
    {
        $this->tokenAuthenticatorDTO = $tokenAuthenticatorDTO;
        $this->responseCollection = $responseCollection;
    }

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
     * @return null|User
     */
    public function getAuthorizedUser(): ?User
    {
        return $this->userRepository->findOneBy([
            'id' => $this->tokenAuthenticatorDTO->getAccessTokenData()?->id
        ]);
    }

    /**
     * @param RolePermissionNameEnum $permissionNameEnum
     *
     * @return void
     */
    public function hasPermissionToAuthUser(RolePermissionNameEnum $permissionNameEnum): void
    {
        if (!$this->getAuthorizedUser()->hasPermission($permissionNameEnum)) {
            $this->responseCollection->accessIsDenied()->sendResponse();
        }
    }
}