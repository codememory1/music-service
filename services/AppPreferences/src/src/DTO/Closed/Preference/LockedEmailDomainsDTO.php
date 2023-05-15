<?php

namespace App\DTO\Closed\Preference;

use App\Enum\PreferenceKey;
use Codememory\Dto\DataTransfer;
use Codememory\Dto\Constraints as DC;
use Symfony\Component\Validator\Constraints as Assert;

#[DC\XSS]
final class LockedEmailDomainsDTO extends DataTransfer
{
    #[DC\ToEnum]
    public ?PreferenceKey $key = null;

    #[DC\ToType]
    #[DC\ExpectOneDimensionalArray(['string'])]
    #[DC\Validation([
        new Assert\NotBlank(message: 'field.is_required.app.preference.value'),
    ])]
    public array $value = [];
}