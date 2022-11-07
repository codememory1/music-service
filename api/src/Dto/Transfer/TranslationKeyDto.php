<?php

namespace App\Dto\Transfer;

use App\Entity\TranslationKey;
use App\Infrastructure\Dto\AbstractDataTransfer;

/**
 * @template-extends AbstractDataTransfer<TranslationKey>
 */
final class TranslationKeyDto extends AbstractDataTransfer
{
    public ?string $key = null;
}