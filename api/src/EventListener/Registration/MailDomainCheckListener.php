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
    /**
     * @var PlatformSettingService
     */
    private PlatformSettingService $platformSettingService;

    /**
     * @param PlatformSettingService $platformSettingService
     */
    public function __construct(PlatformSettingService $platformSettingService)
    {
        $this->platformSettingService = $platformSettingService;
    }

    /**
     * @param UserRegistrationEvent $event
     *
     * @return void
     */
    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        $allowedEmails = $this->platformSettingService->get(PlatformSettingEnum::ALLOWED_REGISTRATION_DOMAINS) ?: [];
        $mailDomain = $this->getMailDomain($event->user);

        if ([] !== $allowedEmails && false === in_array($mailDomain, $allowedEmails, true)) {
            throw new ApiResponseException(451, ResponseTypeEnum::UNAVAILABLE, 'common@bannedDomainMail');
        }
    }

    /**
     * @param User $user
     *
     * @return null|string
     */
    private function getMailDomain(User $user): ?string
    {
        $email = $user->getEmail();

        return explode('@', $email)[1] ?? null;
    }
}