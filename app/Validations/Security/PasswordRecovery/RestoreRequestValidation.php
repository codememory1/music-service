<?php

namespace App\Validations\Security\PasswordRecovery;

use App\Services\Translation\DataService;
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

        /** @var DataService $translation */
        $translation = $args['translations-from-db'];

        $validator
            ->addValidation('email', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('email')->addMessage(
                    $translation->getTranslationByKey('common@invalidEmail')
                );
            });

    }

}