<?php

namespace App\DTO\Closed;

use App\Enum\PreferenceKey;
use Codememory\Dto\DataTransfer;
use Codememory\Dto\Constraints as DC;
use App\Constraints\DTO as ADC;

#[DC\XSS]
final class UpdatePreferenceDTO extends DataTransfer
{
    #[DC\ToType]
    #[ADC\DtoMapper('key', PreferenceKey::DTO_MAPPER)]
    public array $preferences = [];
}