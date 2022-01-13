<?php

namespace App\Validations\Albums;

use App\Services\Translation\DataService;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class CreationValidation
 *
 * @package App\Validations\Albums
 *
 * @author  Danil
 */
class CreationValidation implements ValidationBuildInterface
{

    /**
     * @param ValidatorInterface $validator
     * @param                    ...$args
     *
     * @return void
     */
    public function build(ValidatorInterface $validator, ...$args): void
    {

        /** @var DataService $translation */
        $translation = $args['translations-from-db'];

        $validator
            ->addValidation('name', function (ValidateInterface $validate) use ($translation) {
                $validate
                    ->addRule('required')
                    ->addMessage($translation->getTranslationByKey('album@nameIsRequired'));
                $validate
                    ->addRule('range:5,255')
                    ->addMessage($translation->getTranslationByKey('album@nameLengthRange'));
            })
            ->addValidation('type', function (ValidateInterface $validate) use ($translation) {
                $validate
                    ->addRule('required')
                    ->addMessage($translation->getTranslationByKey('album@typeIsRequired'));
            });

    }

}