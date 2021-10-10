<?php

namespace App\Validations\Playlist;

use Codememory\Components\Translator\Interfaces\TranslationInterface;
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

        /** @var TranslationInterface $translation */
        $translation = $args['translation'];

        $validator
            ->addValidation('name', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('min:5')->addMessage(
                    $translation->getTranslationActiveLang('playlist.minName')
                );
                $validate->addRule('max:100')->addMessage(
                    $translation->getTranslationActiveLang('playlist.maxName')
                );
            })
            ->addValidation('temporary', function (ValidateInterface $validate) use ($translation) {
                $validate->addRule('not-empty:temporaryRule')->addMessage(
                    $translation->getTranslationActiveLang('playlist.temporaryFormat')
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