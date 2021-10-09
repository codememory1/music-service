<?php

namespace App\Orm\Dto;

use App\Orm\Entities\SubscriptionEntity;
use Codememory\Patterns\DTO\AbstractDTO;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class SubscriptionDto
 *
 * @package App\Orm\Dto
 *
 * @author  Danil
 */
final class SubscriptionDto extends AbstractDTO
{

    /**
     * @var SubscriptionEntity
     */
    private SubscriptionEntity $subscriptionEntity;

    /**
     * @param SubscriptionEntity $subscriptionEntity
     */
    public function __construct(SubscriptionEntity $subscriptionEntity)
    {

        $this->subscriptionEntity = $subscriptionEntity;

    }

    /**
     * @inheritDoc
     */
    #[Pure]
    #[ArrayShape([
        'name'        => "string",
        'description' => "string|null",
        'old_price'   => "integer|null",
        'price'       => "integer",
        'is_active'   => "boolean",
        'options'     => "array"
    ])]
    public function getTransformedData(): array
    {

        $options = [];

        foreach ($this->subscriptionEntity->getOptions() as $subscriptionOption) {
            $options[] = [
                'name'  => $subscriptionOption->getOptionName()->getName(),
                'title' => $subscriptionOption->getOptionName()->getTitle()
            ];
        }

        return [
            'name'        => $this->subscriptionEntity->getName(),
            'description' => $this->subscriptionEntity->getDescription(),
            'old_price'   => $this->subscriptionEntity->getOldPrice(),
            'price'       => $this->subscriptionEntity->getPrice(),
            'is_active'   => $this->subscriptionEntity->getIsActive(),
            'options'     => $options
        ];

    }

}