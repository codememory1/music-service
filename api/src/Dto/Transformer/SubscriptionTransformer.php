<?php

namespace App\Dto\Transformer;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\SubscriptionDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Subscription;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Infrastucture\Dto\AbstractDataTransformer;

/**
 * @template-extends AbstractDataTransformer<SubscriptionDto>
 */
final class SubscriptionTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly SubscriptionDto $subscriptionDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->subscriptionDto, $entity ?: new Subscription());
    }
}