<?php

namespace App\DTO;

use App\Entity\Subscription;
use App\Entity\TranslationKey;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Validator\Constraints as AppAssert;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SubscriptionDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class SubscriptionDTO extends AbstractDTO
{

    /**
     * @var array|string[]
     */
    protected array $requestKeys = [
        'name_translation_key',
        'description_translation_key',
        'price',
        'old_price',
        'status'
    ];

    /**
     * @var string|null
     */
    protected ?string $entityClass = Subscription::class;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'subscription@nameIsRequired', payload: 'name_is_required')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'subscription@nameMaxLength',
        payload: 'name_length'
    )]
    #[AppAssert\Exist(
        TranslationKey::class,
        'name',
        'common@titleTranslationKeyNotExist',
        payload: [ApiResponseTypeEnum::CHECK_EXIST, 'title_translation_key_not_exist']
    )]
    private ?string $nameTranslationKey = null;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'common@descriptionIsRequired', payload: 'description_is_required')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'subscription@descriptionMaxLength',
        payload: 'description_length'
    )]
    #[AppAssert\Exist(
        TranslationKey::class,
        'name',
        'common@descriptionTranslationKeyNotExist',
        payload: [ApiResponseTypeEnum::CHECK_EXIST, 'description_translation_key_not_exist']
    )]
    private ?string $descriptionTranslationKey = null;

    /**
     * @var float|null
     */
    #[Assert\NotBlank(message: 'common@priceIsRequired', payload: 'price_is_required')]
    private ?float $price = null;

    /**
     * @var float|null
     */
    private ?float $oldPrice = null;

    /**
     * @var int|null
     */
    #[Assert\NotBlank(message: 'common@statusIsRequired', payload: 'status_is_required')]
    #[Assert\Choice(
        callback: [StatusEnum::class, 'values'],
        message: 'common@statusInvalid',
        payload: 'status_invalid'
    )]
    private ?int $status = null;

    /**
     * @param Subscription $subscription
     * @param array        $exclude
     *
     * @return array
     */
    #[ArrayShape([
        'id'          => "int|null",
        'name'        => "null|string",
        'description' => "null|string",
        'price'       => "float",
        'old_price'   => "float|null",
        'status'      => "int|null",
        'permissions' => "array",
        'created_at'  => "string",
        'updated_at'  => "null|string"
    ])]
    public function toArray(Subscription $subscription, array $exclude = []): array
    {

        $oldPrice = $subscription->getOldPrice();
        $permissions = $subscription->getSubscriptionPermissions()->getValues();

        $subscription = [
            'id'          => $subscription->getId(),
            'name'        => $subscription->getNameTranslationKey(),
            'description' => $subscription->getDescriptionTranslationKey(),
            'price'       => (float) $subscription->getPrice(),
            'old_price'   => empty($oldPrice) ? null : (float) $oldPrice,
            'status'      => $subscription->getStatus(),
            'permissions' => (new SubscriptionPermissionDTO())->transform($permissions),
            'created_at'  => $subscription->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at'  => $subscription->getCreatedAt()?->format('Y-m-d H:i:s'),
        ];

        $this->excludeKeys($subscription, $exclude);

        return $subscription;

    }

    /**
     * @param string|null $nameTranslationKey
     *
     * @return SubscriptionDTO
     */
    public function setNameTranslationKey(?string $nameTranslationKey): self
    {

        $this->nameTranslationKey = $nameTranslationKey;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getNameTranslationKey(): ?string
    {

        return $this->nameTranslationKey;

    }

    /**
     * @param string|null $descriptionTranslationKey
     *
     * @return SubscriptionDTO
     */
    public function setDescriptionTranslationKey(?string $descriptionTranslationKey): self
    {

        $this->descriptionTranslationKey = $descriptionTranslationKey;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getDescriptionTranslationKey(): ?string
    {

        return $this->descriptionTranslationKey;

    }

    /**
     * @param string|null $price
     *
     * @return SubscriptionDTO
     */
    public function setPrice(?string $price): self
    {

        $this->price = (float) $price;

        return $this;

    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {

        return $this->price;

    }

    /**
     * @param string|null $oldPrice
     *
     * @return SubscriptionDTO
     */
    public function setOldPrice(?string $oldPrice): self
    {

        $this->oldPrice = empty($oldPrice) ? null : (float) $oldPrice;

        return $this;

    }

    /**
     * @return float|null
     */
    public function getOldPrice(): ?float
    {

        return $this->oldPrice;

    }

    /**
     * @param string|null $status
     *
     * @return SubscriptionDTO
     */
    public function setStatus(?string $status): self
    {

        $this->status = empty($status) ? -1 : (int) $status;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {

        return $this->status;

    }

}