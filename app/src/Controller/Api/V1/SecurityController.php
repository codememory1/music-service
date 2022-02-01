<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class SecurityController extends AbstractApiController
{

    #[Route('/register', methods: 'POST')]
    public function register(MessageBusInterface $bus): JsonResponse
    {


    }

}