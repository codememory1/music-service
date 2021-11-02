<?php

namespace App\Controllers\V1;

use JetBrains\PhpStorm\NoReturn;

/**
 * Class TranslationController
 *
 * @package App\Controllers\V1
 *
 * @author  Danil
 */
class TranslationController extends AbstractAuthorizationController
{

    /**
     * @return void
     */
    #[NoReturn]
    public function all(): void
    {

        $this->response->json($this->translation->getAllTranslationsActiveLang());

    }

}