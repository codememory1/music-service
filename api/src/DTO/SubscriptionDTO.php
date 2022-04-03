<?php

namespace App\DTO;

use App\DTO\Interceptor\SubscriptionInputPrice;
use App\Entity\Subscription;
use App\Entity\TranslationKey;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Rest\DTO\AbstractDTO;
use App\Validator\Constraints as AppAssert;
use ReflectionException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

/**
 * Class SubscriptionDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class SubscriptionDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'subscription@nameIsRequired')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'subscription@nameMaxLength'
    )]
    #[AppAssert\Exist(
        TranslationKey::class,
        'name',
        'common@titleTranslationKeyNotExist',
        payload: ApiResponseTypeEnum::CHECK_EXIST
    )]
    public ?string $nameTranslationKey = null;

    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'common@descriptionIsRequired')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'subscription@descriptionMaxLength'
    )]
    #[AppAssert\Exist(
        TranslationKey::class,
        'name',
        'common@descriptionTranslationKeyNotExist',
        payload: ApiResponseTypeEnum::CHECK_EXIST
    )]
    public ?string $descriptionTranslationKey = null;

    /**
     * @var null|float
     */
    #[Assert\NotBlank(message: 'common@priceIsRequired')]
    public ?float $price = null;

    /**
     * @var null|float
     */
    public ?float $oldPrice = null;

    /**
     * @var null|int
     */
    #[Assert\NotBlank(message: 'common@statusIsRequired')]
    #[Assert\Choice(
        callback: [StatusEnum::class, 'values'],
        message: 'common@statusInvalid'
    )]
    public ?int $status = null;

    /**
     * @throws ReflectionException
     * @throws ClassNotFoundException
     *
     * @return void
     */
    protected function wrapper(): void
    {
        $this->setEntity(Subscription::class);

        $this
            ->addExpectedRequestKey('name', 'name_translation_key')
            ->addExpectedRequestKey('description', 'description_translation_key')
            ->addExpectedRequestKey('price')
            ->addExpectedRequestKey('old_price')
            ->addExpectedRequestKey('status');

        $this
            ->addInterceptor('price', SubscriptionInputPrice::class)
            ->addInterceptor('old_price', SubscriptionInputPrice::class);
    }
}