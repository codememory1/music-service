<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\LogicBranchDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\LogicBranch;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;

/**
 * @template-extends AbstractDataTransformer<LogicBranchDto>
 */
final class LogicBranchTransformer extends AbstractDataTransformer
{
    public function __construct(
        Request $request,
        private readonly LogicBranchDto $logicBranchDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->logicBranchDto, $entity ?: new LogicBranch());
    }
}