<?php

namespace App\Validations\Translation;

use App\Services\Translation\DataService;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class CreateLanguageValidation
 *
 * @package App\Validations\Translation
 *
 * @author  Danil
 */
class CreateLanguageValidation implements ValidationBuildInterface
{

    /**
     * @inheritDoc
     */
    public function build(ValidatorInterface $validator, ...$args): void
    {

        /** @var DataService $translation */
        $translation = $args['translations-from-db'];

        $validator
            ->addValidation('lang', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('required')->addMessage(
                    $translation->getTranslationByKey('translation@langIsRequired')
                );
            });

    }

}