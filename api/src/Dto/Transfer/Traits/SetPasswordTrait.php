<?php

namespace App\Dto\Transfer\Traits;

use Codememory\Dto\Constraints as DC;
use App\Enum\ValidationRuleEnum;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

trait SetPasswordTrait
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'common@passwordIsRequired'),
        new Assert\Regex(ValidationRuleEnum::PASSWORD_REGEXP, message: 'common@incorrectPasswordBySchema'),
        new Assert\Length(min: ValidationRuleEnum::PASSWORD_MIN_LENGTH, minMessage: 'common@minPasswordLength')
    ])]
    public ?string $password = null;

    #[DC\ToType]
    #[DC\Validation([
        new AppAssert\Between('password', message: 'common@invalidConfirmPassword')
    ])]
    public ?string $passwordConfirm = null;
}