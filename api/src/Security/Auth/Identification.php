<?php

namespace App\Security\Auth;

use App\Dto\Transfer\AuthorizationDto;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Event\UserIdentificationInAuthEvent;
use App\Rest\Http\Exceptions\AuthorizationException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Identification extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function identify(AuthorizationDto $authorizationDto): ?User
    {
        $identifiedUser = $this->em->getRepository(User::class)->findOneBy([
            'email' => $authorizationDto->email
        ]);

        if (null === $identifiedUser) {
            throw AuthorizationException::failedToIdentify();
        }

        $this->eventDispatcher->dispatch(new UserIdentificationInAuthEvent(
            $authorizationDto,
            $identifiedUser
        ), EventEnum::IDENTIFICATION_IN_AUTH->value);

        return $identifiedUser;
    }
}