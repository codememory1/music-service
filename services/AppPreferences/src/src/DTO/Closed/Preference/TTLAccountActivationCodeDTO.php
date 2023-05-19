<?php

namespace App\DTO\Closed\Preference;

use App\Enum\PreferenceKey;
use Codememory\Dto\DataTransfer;
use Codememory\Dto\Constraints as DC;
use Symfony\Component\Validator\Constraints as Assert;

#[DC\XSS]
final class TTLAccountActivationCodeDTO extends DataTransfer
{
    #[DC\ToEnum]
    public ?PreferenceKey $key = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'field.is_required.app.preference.value'),
        new Assert\Range(
            notInRangeMessage: 'field.length.min_max.app.preference.ttl_account_activation_code.value',
            min: 0,
            max: PHP_INT_MAX
        )
    ])]
    public ?int $value = null;
}