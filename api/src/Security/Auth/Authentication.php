<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Event\UserAuthenticationInAuthEvent;
use App\Rest\Http\Exceptions\AuthorizationException;
use App\Service\HashingService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Authentication.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class Authentication
{
    #[Required]
    public ?HashingService $hashingService = null;

    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    /**
     * @param AuthorizationDTO $authorizationDTO
     * @param User             $identifiedUser
     *
     * @return User
     */
    public function authenticate(AuthorizationDTO $authorizationDTO, User $identifiedUser): User
    {
        $realPassword = $authorizationDTO->password;
        $hashPassword = $identifiedUser->getPassword();

        if (false === $this->hashingService->compare($realPassword, $hashPassword)) {
            throw AuthorizationException::incorrectPassword();
        }

        $this->eventDispatcher->dispatch(new UserAuthenticationInAuthEvent(
            $authorizationDTO,
            $identifiedUser
        ));

        return $identifiedUser;
    }
}