<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\LogicBranch;
use App\Enum\LogicBranchStatusEnum;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<LogicBranch>
 */
final class LogicBranchDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'logicBranch@invalidStatus')]
    #[DtoConstraints\ToEnumConstraint(LogicBranchStatusEnum::class)]
    public ?LogicBranchStatusEnum $status = null;
}