<?php

namespace App\Security\PasswordReset;

use App\Dto\Transfer\RequestRestorationPasswordDto;
use App\Entity\PasswordReset;
use App\Event\AfterRequestRestorationPasswordEvent;
use App\Event\RequestRestorationPasswordEvent;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class RequestRestoration
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function send(RequestRestorationPasswordDto $dto): PasswordReset
    {
        $this->validator->validate($dto);

        $passwordReset = $dto->getEntity();

        $passwordReset->setTtl('10m');
        $passwordReset->setInProcessStatus();

        $this->eventDispatcher->dispatch(new RequestRestorationPasswordEvent($passwordReset));

        $this->flusher->save($passwordReset);

        $this->eventDispatcher->dispatch(new AfterRequestRestorationPasswordEvent($passwordReset));

        return $passwordReset;
    }
}