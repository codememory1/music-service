<?php

namespace App\EventListener\Registration;

use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Enum\PlatformSettingEnum;
use App\Event\UserRegistrationEvent;
use App\Exception\HttpException;
use App\Service\PlatformSetting;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(UserRegistrationEvent::class, 'onUserRegistration', 2)]
final class MailDomainCheckListener
{
    public function __construct(
        private readonly PlatformSetting $platformSettingService
    ) {
    }

    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        $allowedEmails = $this->platformSettingService->get(PlatformSettingEnum::ALLOWED_REGISTRATION_DOMAINS) ?: [];
        $mailDomain = $this->getMailDomain($event->user);
        $isPassed = true;

        foreach ($allowedEmails as $allowedEmail) {
            if (str_starts_with($allowedEmail, '/') && str_ends_with($allowedEmail, '/')) {
                $isPassed = 1 === preg_match($allowedEmail, $mailDomain);
            } else {
                $isPassed = $mailDomain === $allowedEmail;
            }

            if ($isPassed) {
                break;
            }
        }

        if (false === $isPassed) {
            throw new HttpException(451, PlatformCodeEnum::INACCESSIBLE_DATA, 'common@bannedDomainMail');
        }
    }

    private function getMailDomain(User $user): ?string
    {
        $email = $user->getEmail();

        return explode('@', $email)[1] ?? null;
    }
}