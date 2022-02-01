<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserAccountController
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
class UserAccountController extends AbstractController
{

    /**
     * @return Response
     */
    #[Route('/{path}', requirements: ['path' => '.*'], methods: 'GET')]
    public function index(): Response
    {

        return $this->render('template.html.twig');

    }

}