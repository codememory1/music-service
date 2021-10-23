<?php

namespace App\Validations\Security\PasswordReset;

use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class RestoreRequestValidation
 *
 * @package App\Validations\Security\PasswordReset
 *
 * @author  Danil
 */
class RestoreRequestValidation implements ValidationBuildInterface
{

    /**
     * @inheritDoc
     */
    public function build(ValidatorInterface $validator, ...$args): void
    {

        /** @var TranslationInterface $translation */
        $translation = $args['translation'];

        $validator
            ->addValidation('email', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('email')->addMessage(
                    $translation->getTranslationActiveLang('register.invalidEmail')
                );
            });

    }

}