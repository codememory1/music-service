<?php

namespace App\Security\PasswordReset;

use App\Dto\Transfer\RequestRestorationPasswordDto;
use App\Entity\PasswordReset;
use App\Enum\PlatformSettingEnum;
use App\Event\AfterRequestRestorationPasswordEvent;
use App\Event\RequestRestorationPasswordEvent;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Service\PlatformSetting;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class RequestRestoration
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly PlatformSetting $platformSetting,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function send(RequestRestorationPasswordDto $dto): PasswordReset
    {
        $this->validator->validate($dto);

        $passwordReset = $dto->getEntity();

        $passwordReset->setTtl($this->platformSetting->get(PlatformSettingEnum::PASSWORD_RESET_CODE_TTL));
        $passwordReset->setInProcessStatus();

        $this->eventDispatcher->dispatch(new RequestRestorationPasswordEvent($passwordReset));

        $this->flusher->save($passwordReset);

        $this->eventDispatcher->dispatch(new AfterRequestRestorationPasswordEvent($passwordReset));

        return $passwordReset;
    }
}