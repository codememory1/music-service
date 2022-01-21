<?php

namespace App\Controller\Api\V1;

use App\Service\Response\ApiResponseSchema;
use App\Service\Response\ApiResponseService;
use App\Service\Translator\TranslationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class SecurityController extends AbstractController
{

    #[Route('/test', methods: ['GET'])]
    public function test()
    {

        $schema = new ApiResponseSchema('error', 500);

        $schema
            ->setMessage('input_validation', 'name_is_required', 'Имя обязательно к заполнению')
            ->setData([
                'tokens' => [
                    'access' => 'cdsc',
                    'refresh' => 'csdc'
                ]
            ]);

        $api = new ApiResponseService($schema);

        $api->make();

    }

}