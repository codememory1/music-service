<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\MonetizationBranchDto;
use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<MonetizationBranchDto>
 */
final class MonetizationBranchTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly MonetizationBranchDto $monetizationBranchDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->monetizationBranchDto, $entity);
    }
}