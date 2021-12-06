<?php

namespace App\Validations\Track;

use App\Services\Translation\DataService;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class EditTrackTextValidation
 *
 * @package App\Validations\Track
 *
 * @author  Danil
 */
class EditTrackTextValidation implements ValidationBuildInterface
{

    /**
     * @inheritDoc
     */
    public function build(ValidatorInterface $validator, ...$args): void
    {

        /** @var DataService $translation */
        $translation = $args['translations-from-db'];

        $validator->addValidation('text', function (ValidateInterface $validate) use ($translation) {
            $validate
                ->addRule('required')
                ->addMessage(
                    $translation->getTranslationByKey('track@textIsRequired')
                );
        });

    }

}