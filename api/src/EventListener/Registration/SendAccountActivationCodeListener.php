<?php

namespace App\EventListener\Registration;

use App\Entity\AccountActivationCode;
use App\Enum\PlatformSettingEnum;
use App\Event\SuccessUserRegistrationEvent;
use App\Infrastructure\Doctrine\Flusher;
use App\Service\MailMessaging;
use App\Service\PlatformSetting;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[AsEventListener(SuccessUserRegistrationEvent::class, 'onUserRegistration', 1)]
final class SendAccountActivationCodeListener
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly PlatformSetting $platformSetting,
        private readonly MailMessaging $mailMessagingService
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onUserRegistration(SuccessUserRegistrationEvent $event): void
    {
        $accountActivationCodeEntity = new AccountActivationCode();

        $accountActivationCodeEntity->setUser($event->user);
        $accountActivationCodeEntity->setTtl($this->platformSetting->get(PlatformSettingEnum::ACCOUNT_ACTIVATION_CODE_TTL));

        $this->flusher->save($accountActivationCodeEntity);

        $this->mailMessagingService->sendAccountActivationCode($accountActivationCodeEntity);
    }
}