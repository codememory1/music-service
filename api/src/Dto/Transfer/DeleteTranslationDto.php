<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;

final class DeleteTranslationDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    public bool $deleteKey = false;
}