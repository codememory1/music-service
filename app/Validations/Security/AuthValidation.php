<?php

namespace App\Validations\Security;

use App\Services\Translation\DataService;
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

        /** @var DataService $translation */
        $translation = $args['translations-from-db'];

        $validator
            ->addValidation('username', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage($translation->getTranslationByKey('auth@loginIsRequired'));
            })
            ->addValidation('password', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage($translation->getTranslationByKey('security@passwordIsRequired'));
            });

    }

}