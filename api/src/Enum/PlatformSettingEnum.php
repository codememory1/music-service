<?php

namespace App\Enum;

enum PlatformSettingEnum
{
    case ALLOWED_REGISTRATION_DOMAINS;
    case MULTIMEDIA_DURATION_TRACK_KEY;
    case MULTIMEDIA_DURATION_CLIP_KEY;
    case AUTO_REJECT_OFFERED_STREAMING;
    case PERCENT_FOR_ARTIST_INCOME;
    case PERCENT_ARTIST_INCOME_FROM_TURNOVER;
    case MONTHLY_EXPENSES;
    case ACCOUNT_ACTIVATION_CODE_TTL;
    case PASSWORD_RESET_CODE_TTL;
    case ALLOWED_MULTIMEDIA_EXTERNAL_SERVICES;
    case PAGINATION_MAX_LIMIT;
    case SOCIAL_NETWORK;
}