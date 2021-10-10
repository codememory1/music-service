<?php

namespace App\Validations\Auth;

use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class AuthValidation
 *
 * @package App\Validations
 *
 * @author  Danil
 */
class AuthValidation implements ValidationBuildInterface
{

    /**
     * @inheritDoc
     */
    public function build(ValidatorInterface $validator, ...$args): void
    {

        /** @var TranslationInterface $translation */
        $translation = $args['translation'];

        $validator
            ->addValidation('username', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage($translation->getTranslationActiveLang('auth.requiredUsername'));
            })
            ->addValidation('password', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage($translation->getTranslationActiveLang('auth.requiredPassword'));
            });

    }

}