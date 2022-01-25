<?php

namespace App\Acme\XhprofBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ResultController
 *
 * @package App\Acme\XhprofBundle\Controller
 *
 * @author  Codememory
 */
class ResultController extends AbstractController
{

    /**
     * @return Response
     */
    #[Route('/xhprof/index', methods: 'GET')]
    public function index(): Response
    {

        return require __DIR__ . '/../../../../vendor/lox/xhprof/xhprof_html/index.php';

    }

}