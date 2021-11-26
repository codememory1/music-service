<?php

namespace App\Validations\Translation;

use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class AddTranslationValidation
 *
 * @package App\Validations\Translation
 *
 * @author  Danil
 */
class AddTranslationValidation implements ValidationBuildInterface
{

    /**
     * @inheritDoc
     */
    public function build(ValidatorInterface $validator, ...$args): void
    {

        /** @var TranslationInterface $translation */
        $translation = $args['translation'];

        $validator
            ->addValidation('key', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage(
                    $translation->getTranslationActiveLang('translation.translationKeyIsRequired')
                );
                $validate->addRule('max:64')->addMessage(
                    $translation->getTranslationActiveLang('translation.translationKeyMax')
                );
            })
            ->addValidation('translation', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage(
                    $translation->getTranslationActiveLang('translation.translationIsRequired')
                );
            });

    }

}