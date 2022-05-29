<?php

namespace App\DTO\Traits;

use App\Enum\ValidationRuleEnum;

use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait SetPasswordTrait.
 *
 * @package App\DTO\Traits
 *
 * @author  Codememory
 */
trait SetPasswordTrait
{
    #[Assert\NotBlank(message: 'common@passwordIsRequired')]
    #[Assert\Regex(ValidationRuleEnum::PASSWORD_REGEXP, message: 'common@incorrectPasswordBySchema')]
    #[Assert\Length(min: ValidationRuleEnum::PASSWORD_MIN_LENGTH, minMessage: 'common@minPasswordLength')]
    public ?string $password = null;

    #[AppAssert\Between('password', message: 'common@invalidConfirmPassword')]
    public ?string $passwordConfirm = null;
}