<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Infrastucture\Dto\AbstractDataTransfer;

final class DeleteTranslationDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    public bool $deleteKey = false;
}