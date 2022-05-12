<?php

namespace App\Controller;

use App\Rest\Http\Exceptions\ApiResponseException;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseSchema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TestController
 *
 * @package App\Controller
 *
 * @author  codememory
 */
class TestController extends AbstractController
{
    #[Route('/red', methods: 'GET')]
    public function t(ResponseSchema $responseSchema, Response $response)
    {
        throw new ApiResponseException(400, 'validation', 'common@red');
//        $responseSchema->setType('red')->setMessage('common@red');
//
//        return $response->send($responseSchema);
    }
}