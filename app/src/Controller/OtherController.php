<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OtherController
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
class OtherController extends AbstractController
{

    #[Route('/{path}', requirements: ['path' => '.*'], methods: 'GET')]
    public function index(): Response
    {

        return $this->render('template.html.twig');

    }

}