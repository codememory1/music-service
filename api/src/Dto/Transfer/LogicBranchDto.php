<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\LogicBranch;
use App\Enum\LogicBranchStatusEnum;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<LogicBranch>
 */
final class LogicBranchDto extends DataTransfer
{
    #[DC\ToEnum]
    #[DC\Validation([
        new Assert\NotBlank(message: 'logicBranch@invalidStatus')
    ])]
    public ?LogicBranchStatusEnum $status = null;
}