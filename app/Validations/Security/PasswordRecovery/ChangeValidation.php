<?php

namespace App\Validations\Security\PasswordRecovery;

use App\Services\Translation\DataService;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class ChangeValidation
 *
 * @package App\Validations\Security\PasswordRecovery
 *
 * @author  Codememory
 */
class ChangeValidation implements ValidationBuildInterface
{

    /**
     * @inheritDoc
     */
    public function build(ValidatorInterface $validator, ...$args): void
    {

        /** @var DataService $translation */
        $translation = $args['translations-from-db'];

        $validator
            ->addValidation('code', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('regex:^[0-9]+$')->addMessage(
                    $translation->getTranslationByKey('passwordRecovery@invalidCode')
                );
            })
            ->addValidation('password', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('min:8')->addMessage(
                    $translation->getTranslationByKey('register@minPassword')
                );
                $validate->addRule('regex:^[a-zA-Z0-9@%_.-]+$')->addMessage(
                    $translation->getTranslationByKey('register@invalidPassword')
                );
            })
            ->addValidation('password_confirm', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('same:password')->addMessage(
                    $translation->getTranslationByKey('register@samePassword')
                );
            });

    }

}