<?php

namespace App\Enum;

enum ValidationRuleEnum: string
{
    public const PASSWORD_REGEXP = '/^[a-zA-Z0-9\-\_\%\@\.\&\+]+$/';
    public const PASSWORD_MIN_LENGTH = 8;
}