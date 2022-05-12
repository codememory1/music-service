<?php

namespace App\Controller;

use App\Entity\Language;
use App\Rest\Http\Exceptions\ApiResponseException;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseSchema;
use App\Service\JwtTokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
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
    public function t(JwtTokenGenerator $jwtTokenGenerator)
    {
        dd($jwtTokenGenerator->encode([], 'jwt.access_private_key', 'jwt.access_ttl'));
    }
}