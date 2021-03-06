<?php

namespace App\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Event\UserIdentificationInAuthEvent;
use App\Rest\Http\Exceptions\AuthorizationException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Identification.
 *
 * @package App\Security\Auth
 *
 * @author  Codememory
 */
class Identification extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    /**
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return null|User
     */
    public function identify(AuthorizationDTO $authorizationDTO): ?User
    {
        $identifiedUser = $this->em->getRepository(User::class)->findOneBy([
            'email' => $authorizationDTO->email
        ]);

        if (null === $identifiedUser) {
            throw AuthorizationException::failedToIdentify();
        }

        $this->eventDispatcher->dispatch(new UserIdentificationInAuthEvent(
            $authorizationDTO,
            $identifiedUser
        ), EventEnum::IDENTIFICATION_IN_AUTH->value);

        return $identifiedUser;
    }
}