<?php

namespace App\Enum;

use App\DTO\Closed\Preference\LockedEmailDomainsDTO;
use App\DTO\Closed\Preference\TTLAccountActivationCodeDTO;

enum PreferenceKey: string
{
    case LOCKED_EMAIL_DOMAINS = 'preference.app.locked_email_domains';
    case TTL_ACCOUNT_ACTIVATION_CODE = 'preference.app.ttl_account_activation_code';

    public const DTO_MAPPER = [
        self::LOCKED_EMAIL_DOMAINS->name => LockedEmailDomainsDTO::class,
        self::TTL_ACCOUNT_ACTIVATION_CODE->name => TTLAccountActivationCodeDTO::class
    ];
}