<?php

namespace App\Validations\Translation;

use App\Services\Translation\DataService;
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

        /** @var DataService $translation */
        $translation = $args['translations-from-db'];

        $validator
            ->addValidation('key', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage(
                    $translation->getTranslationByKey('translation@translationKeyIsRequired')
                );
                $validate->addRule('max:64')->addMessage(
                    $translation->getTranslationByKey('translation@translationKeyMaxLength')
                );
            })
            ->addValidation('translation', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage(
                    $translation->getTranslationByKey('translation@translationIsRequired')
                );
            });

    }

}