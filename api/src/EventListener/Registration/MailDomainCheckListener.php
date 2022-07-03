<?php

namespace App\EventListener\Registration;

use App\Entity\User;
use App\Enum\PlatformSettingEnum;
use App\Enum\ResponseTypeEnum;
use App\Event\UserRegistrationEvent;
use App\Rest\Http\Exceptions\ApiResponseException;
use App\Service\PlatformSettingService;

/**
 * Class MailDomainCheckListener.
 *
 * @package App\EventListener\Registration
 *
 * @author  Codememory
 */
class MailDomainCheckListener
{
    private PlatformSettingService $platformSettingService;

    public function __construct(PlatformSettingService $platformSettingService)
    {
        $this->platformSettingService = $platformSettingService;
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
            throw new ApiResponseException(451, ResponseTypeEnum::UNAVAILABLE, 'common@bannedDomainMail');
        }
    }

    private function getMailDomain(User $user): ?string
    {
        $email = $user->getEmail();

        return explode('@', $email)[1] ?? null;
    }
}