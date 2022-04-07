<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Rest\Http\Response;
use App\Security\AbstractSecurity;
use App\Service\HashingService;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Authentication.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class Authentication extends AbstractSecurity
{
    /**
     * @var null|HashingService
     */
    private ?HashingService $hashingService = null;

    /**
     * @param HashingService $hashingService
     *
     * @return $this
     */
    #[Required]
    public function setHashingService(HashingService $hashingService): self
    {
        $this->hashingService = $hashingService;

        return $this;
    }

    /**
     * @param User             $identifiedUser
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return Response|User
     */
    public function authenticate(User $identifiedUser, AuthorizationDTO $authorizationDTO): Response|User
    {
        // Check compare password with identified user
        if (!$this->comparePassword($identifiedUser, $authorizationDTO)) {
            return $this->responseCollection->invalid('user@passwordIsIncorrect')->getResponse();
        }

        return $identifiedUser;
    }

    /**
     * @param User             $identifiedUser
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return bool
     */
    private function comparePassword(User $identifiedUser, AuthorizationDTO $authorizationDTO): bool
    {
        return $this->hashingService->compare(
            $authorizationDTO->password,
            $identifiedUser->getPassword()
        );
    }
}