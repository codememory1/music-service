<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\DTO\Interceptors\AsBooleanInterceptor;
use App\DTO\Interceptors\AsEnumInterceptor;
use App\DTO\Interceptors\AsFloatInterceptor;
use App\DTO\Interceptors\AsFloatOrNullInterceptor;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Subscription;
use App\Entity\TranslationKey;
use App\Enum\ResponseTypeEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SubscriptionDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<Subscription>
 *
 * @author  Codememory
 */
class SubscriptionDTO extends AbstractDTO
{
    /**
     * @inheritDoc
     */
    protected EntityInterface|string|null $entity = Subscription::class;

    #[Assert\NotBlank(message: 'subscription@keyIsRequired')]
    public ?string $key = null;

    #[Assert\NotBlank(message: 'subscription@titleIsRequired')]
    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@titleTranslationKeyNotExist',
        payload: [ResponseTypeEnum::NOT_EXIST, 409]
    )]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'subscription@descriptionIsRequired')]
    #[AppAssert\Exist(
        TranslationKey::class,
        'key',
        'common@shortDescriptionTranslationKeyNotExist',
        payload: [ResponseTypeEnum::NOT_EXIST, 409],
    )]
    public ?string $description = null;

    #[Assert\Type('float', message: 'common@invalidOldPrice')]
    public ?float $oldPrice = null;

    #[Assert\NotBlank(message: 'subscription@priceIsRequired')]
    #[Assert\Type('float', message: 'common@invalidPrice')]
    public ?float $price = null;

    /**
     * @var null|bool
     */
    public ?bool $isRecommend = null;

    /**
     * @var null|array
     */
    public ?array $permissions = null;

    #[Assert\NotBlank(message: 'subscription@statusIsRequired')]
    public ?SubscriptionStatusEnum $status = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('key');
        $this->addExpectKey('title');
        $this->addExpectKey('description');
        $this->addExpectKey('old_price', 'oldPrice');
        $this->addExpectKey('price');
        $this->addExpectKey('is_recommend', 'isRecommend');
        $this->addExpectKey('permissions');
        $this->addExpectKey('status');

        $this->preventSetterCallForKeys(['permissions']);

        $this->addInterceptor('permissions', new AsArrayInterceptor());
        $this->addInterceptor('oldPrice', new AsFloatOrNullInterceptor());
        $this->addInterceptor('price', new AsFloatInterceptor());
        $this->addInterceptor('isRecommend', new AsBooleanInterceptor());
        $this->addInterceptor('status', new AsEnumInterceptor(SubscriptionStatusEnum::class));
    }
}