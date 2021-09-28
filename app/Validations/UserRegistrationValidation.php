<?php

namespace App\Validations;

use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class UserRegistrationValidation
 *
 * @package App\Validations
 *
 * @author  Danil
 */
class UserRegistrationValidation implements ValidationBuildInterface
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
                $validate->addRule('required')->addMessage($translation->getTranslationActiveLang('register.nameNotSpecified'));
                $validate->addRule('range:3,32')->addMessage($translation->getTranslationActiveLang('register.rangeName'));
            })
            ->addValidation('email', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('email')->addMessage($translation->getTranslationActiveLang('register.invalidEmail'));
            })
            ->addValidation('password', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('min:8')->addMessage($translation->getTranslationActiveLang('register.minPassword'));
                $validate->addRule('regex:^[a-zA-Z0-9@%_.-]+$')->addMessage($translation->getTranslationActiveLang('register.minPassword'));
            })
            ->addValidation('password-confirm', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('same:password')->addMessage($translation->getTranslationActiveLang('register.samePassword'));
            });

    }

}