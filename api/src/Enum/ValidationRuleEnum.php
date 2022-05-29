<?php

namespace App\Enum;

/**
 * Enum ValidationRuleEnum.
 *
 * @package App\Enum
 *
 * @author  codememory
 */
enum ValidationRuleEnum: string
{
    public const PASSWORD_REGEXP = '/^[a-zA-Z0-9\-\_\%\@\.\&\+]+$/';
    public const PASSWORD_MIN_LENGTH = 8;
}