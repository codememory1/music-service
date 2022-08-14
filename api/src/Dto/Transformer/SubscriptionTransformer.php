<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\SubscriptionDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Subscription;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<SubscriptionDto>
 */
final class SubscriptionTransformer extends AbstractDataTransformer
{
    private SubscriptionDto $subscriptionDto;

    #[Pure]
    public function __construct(Request $request, SubscriptionDto $subscriptionDto)
    {
        parent::__construct($request);

        $this->subscriptionDto = $subscriptionDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->subscriptionDto, $entity ?: new Subscription());
    }
}