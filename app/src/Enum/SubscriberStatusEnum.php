<?php

namespace App\Enum;

/**
 * Enum SubscriberStatusEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum SubscriberStatusEnum: int
{
    case SUBSCRIBED = 1;
    case UNSUBSCRIBED = 0;
}