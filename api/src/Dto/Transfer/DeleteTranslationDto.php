<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Infrastructure\Dto\AbstractDataTransfer;

final class DeleteTranslationDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    public bool $deleteKey = false;
}