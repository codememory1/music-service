<?php

namespace App\Dto\Transfer;

use App\Entity\TranslationKey;

/**
 * Class TranslationKeyDto.
 *
 * @package App\Dto\Transfer
 * @template-extends AbstractDataTransfer<TranslationKey>
 *
 * @author  Codememory
 */
final class TranslationKeyDto extends AbstractDataTransfer
{
    public ?string $key = null;
}