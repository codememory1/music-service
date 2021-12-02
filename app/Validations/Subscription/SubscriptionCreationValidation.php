<?php

namespace App\Validations\Subscription;

use App\Services\Translation\DataService;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class SubscriptionCreationValidation
 *
 * @package App\Validations\Subscription
 *
 * @author  Danil
 */
class SubscriptionCreationValidation implements ValidationBuildInterface
{

    /**
     * @inheritDoc
     */
    public function build(ValidatorInterface $validator, ...$args): void
    {

        /** @var DataService $translation */
        $translation = $args['translations-from-db'];

        $validator
            ->addValidation('name', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage(
                    $translation->getTranslationByKey('subscription@nameIsRequired')
                );
            })
            ->addValidation('old_price', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('not-empty:oldPriceRule')->addMessage(
                    $translation->getTranslationByKey('subscription@priceInTypeNumber')
                );
            })
            ->addValidation('price', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('number')->addMessage(
                    $translation->getTranslationByKey('subscription@priceInTypeNumber')
                );
            })
            ->addValidation('active', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('boolean')->addMessage(
                    $translation->getTranslationByKey('subscription@activeInTypeBoolean')
                );
            });

    }

    /**
     * @param mixed $validatedValue
     *
     * @return bool
     */
    public static function oldPriceRule(mixed $validatedValue): bool
    {

        return is_numeric($validatedValue);

    }

}