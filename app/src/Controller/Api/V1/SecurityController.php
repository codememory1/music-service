<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Service\Security\UserRegistrationService;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SecurityController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class SecurityController extends AbstractApiController
{

    /**
     * @param Request                  $request
     * @param ValidatorInterface       $validator
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/register', methods: 'POST')]
    public function register(Request $request, ValidatorInterface $validator, EventDispatcherInterface $eventDispatcher): JsonResponse
    {

        $userRegistrationService = new UserRegistrationService($request, $this->response, $this->managerRegistry);

        return $userRegistrationService->register($validator, $eventDispatcher)->make();

    }

}