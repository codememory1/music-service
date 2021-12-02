<?php

namespace App\Validations\Security;

use App\Services\Translation\DataService;
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

        /** @var DataService $translation */
        $translation = $args['translations-from-db'];

        $validator
            ->addValidation('name', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage(
                    $translation->getTranslationByKey('register@nameIsRequired')
                );
                $validate->addRule('range:3,32')->addMessage(
                    $translation->getTranslationByKey('register@nameLengthRange')
                );
            })
            ->addValidation('email', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('email')->addMessage(
                    $translation->getTranslationByKey('common@invalidEmail')
                );
            })
            ->addValidation('password', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('min:8')->addMessage(
                    $translation->getTranslationByKey('security@minPassword')
                );
                $validate->addRule('regex:^[a-zA-Z0-9@%_.-]+$')->addMessage(
                    $translation->getTranslationByKey('register@invalidPassword')
                );
            })
            ->addValidation('password_confirm', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('same:password')->addMessage(
                    $translation->getTranslationByKey('security@samePassword')
                );
            });

    }

}