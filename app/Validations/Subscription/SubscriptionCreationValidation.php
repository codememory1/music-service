<?php

namespace App\Validations\Subscription;

use Codememory\Components\Translator\Interfaces\TranslationInterface;
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

        /** @var TranslationInterface $translation */
        $translation = $args['translation'];

        $validator
            ->addValidation('name', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage(
                    $translation->getTranslationActiveLang('subscription.requiredNameRule')
                );
            })
            ->addValidation('old_price', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('not-empty:oldPriceRule')->addMessage(
                    $translation->getTranslationActiveLang('subscription.numericPriceRule')
                );
            })
            ->addValidation('price', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('number')->addMessage(
                    $translation->getTranslationActiveLang('subscription.numericPriceRule')
                );
            })
            ->addValidation('active', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('boolean')->addMessage(
                    $translation->getTranslationActiveLang('subscription.activeRule')
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