<?php

namespace App\Validations\Track;

use App\Services\Translation\DataService;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class AddTrackValidation
 *
 * @package App\Validations\Track
 *
 * @author  Danil
 */
class AddTrackValidation implements ValidationBuildInterface
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
                $validate
                    ->addRule('required')
                    ->addMessage($translation->getTranslationByKey('track@nameIsRequired'))
                    ->addRule('max:255')
                    ->addMessage($translation->getTranslationByKey('track@nameMaxLength'));
            })
            ->addValidation('category', function (ValidateInterface $validate) use ($translation) {
                $validate
                    ->addRule('required')
                    ->addMessage($translation->getTranslationByKey('track@categoryIsRequired'));
            })
            ->addValidation('album', function (ValidateInterface $validate) use ($translation) {
                $validate
                    ->addRule('required')
                    ->addMessage($translation->getTranslationByKey('track@albumIsRequired'));
            })
            ->addValidation('duration_time', function (ValidateInterface $validate) use ($translation) {
                $validate
                    ->addRule('required')
                    ->addMessage($translation->getTranslationByKey('track@durationTimeIsRequired'));
            })
            ->addValidation('foul_language', function (ValidateInterface $validate) use ($translation) {
                $validate
                    ->addRule('required')
                    ->addMessage($translation->getTranslationByKey('track@foulLanguageIsRequired'));
            });

    }

}