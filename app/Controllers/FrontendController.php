<?php

namespace App\Controllers;

use Codememory\Components\Translator\Translation;
use Kernel\Controller\AbstractController;

/**
 * Class FrontendController
 *
 * @package App\Controllers
 *
 * @author  Danil
 */
class FrontendController extends AbstractController
{

    /**
     * @return void
     */
    public function home(): void
    {

        $this->templateRender('home');

    }

    /**
     * @return void
     */
    public function player(): void
    {

        $this->templateRender('player');

    }

    /**
     * @return void
     */
    public function account(): void
    {

        $this->templateRender('account');

    }

    /**
     * @param string $template
     *
     * @return void
     */
    private function templateRender(string $template): void
    {

        /** @var Translation $translation */
        $translation = $this->get('translator');

        $this->render($template, [
            'parameters' => [
                'active_lang'     => $translation->language->getActiveLang(),
                'app_name'        => env('app.name'),
                'app_title'       => env('app.title'),
                'app_description' => env('app.description'),
                'app_url'         => env('app.full-url'),
                'app_package'     => env('app.package')
            ]
        ]);

    }

}