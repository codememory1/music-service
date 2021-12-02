<?php

namespace App\Validations\Playlist;

use App\Services\Translation\DataService;
use Codememory\Components\Validator\Interfaces\ValidateInterface;
use Codememory\Components\Validator\Interfaces\ValidationBuildInterface;
use Codememory\Components\Validator\Interfaces\ValidatorInterface;

/**
 * Class PlaylistCreationValidation
 *
 * @package App\Validations
 *
 * @author  Danil
 */
class PlaylistCreationValidation implements ValidationBuildInterface
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
                $validate->addRule('range:5,100')->addMessage(
                    $translation->getTranslationByKey('playlist@nameLengthRange')
                );
            })
            ->addValidation('temporary', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('not-empty:temporaryRule')->addMessage(
                    $translation->getTranslationByKey('playlist@temporaryFormat')
                );
            });

    }

    /**
     * @param mixed $validatedValue
     *
     * @return bool
     */
    public static function temporaryRule(mixed $validatedValue): bool
    {

        if (preg_match('/^([0-9]{2}\.){2}[0-9]{4}\s[0-9]{2}:[0-9]{2}$/', trim($validatedValue))) {
            return true;
        }

        return false;

    }

}