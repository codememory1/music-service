<?php

namespace App\Validations\Track;

use App\Services\Track\AddSubtitlesService;
use App\Services\Translation\DataService;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class AddSubtitlesValidation
 *
 * @package App\Validations\Track
 *
 * @author  Danil
 */
class AddSubtitlesValidation implements ValidationBuildInterface
{
    
    /**
     * @inheritDoc
     */
    public function build(ValidatorInterface $validator, ...$args): void
    {

        /** @var DataService $translation */
        $translation = $args['translations-from-db'];

        $validator
            ->addValidation('type', function (ValidateInterface $validate) use ($translation) {
                $validate
                    ->addRule(sprintf('only:%s', implode(',', AddSubtitlesService::TYPES)))
                    ->addMessage(
                        $translation->getTranslationByKey('track@invalidSubtitlesType')
                    );
            });

    }

}