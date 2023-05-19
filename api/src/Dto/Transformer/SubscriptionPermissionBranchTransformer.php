<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\SubscriptionPermissionBranchDto;
use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\Dto\AbstractDataTransformer;
use Codememory\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<SubscriptionPermissionBranchDto>
 */
final class SubscriptionPermissionBranchTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly SubscriptionPermissionBranchDto $subscriptionPermissionBranchDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->subscriptionPermissionBranchDto, $entity);
    }
}