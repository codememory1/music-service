<?php

namespace App\Dto\Transfer\Traits;

use App\Dto\Constraints as DtoConstraints;
use App\Enum\ValidationRuleEnum;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

trait SetPasswordTrait
{
    #[Assert\NotBlank(message: 'common@passwordIsRequired')]
    #[Assert\Regex(ValidationRuleEnum::PASSWORD_REGEXP, message: 'common@incorrectPasswordBySchema')]
    #[Assert\Length(min: ValidationRuleEnum::PASSWORD_MIN_LENGTH, minMessage: 'common@minPasswordLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $password = null;

    #[AppAssert\Between('password', message: 'common@invalidConfirmPassword')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $passwordConfirm = null;
}