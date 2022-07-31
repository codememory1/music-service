<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;

/**
 * Class DeleteTranslationDto.
 *
 * @package App\Dto\Transfer
 *
 * @author  Codememory
 */
final class DeleteTranslationDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    public bool $deleteKey = false;
}