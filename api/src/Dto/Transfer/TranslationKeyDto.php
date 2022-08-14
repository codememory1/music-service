<?php

namespace App\Dto\Transfer;

use App\Entity\TranslationKey;

/**
 * @template-extends AbstractDataTransfer<TranslationKey>
 */
final class TranslationKeyDto extends AbstractDataTransfer
{
    public ?string $key = null;
}