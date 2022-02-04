<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Service\Security\Auth\UserAuthorizationService;
use App\Service\Security\UserActivationAccountService;
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
    #[Route('/user/register', methods: 'POST')]
    public function register(Request $request, ValidatorInterface $validator, EventDispatcherInterface $eventDispatcher): JsonResponse
    {

        $userRegistrationService = new UserRegistrationService($request, $this->response, $this->managerRegistry);

        return $userRegistrationService->register($validator, $eventDispatcher)->make();

    }

    /**
     * @param string  $hash
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/user/activate-account/{hash<.+>}', methods: 'GET')]
    public function activateAccount(string $hash, Request $request): JsonResponse
    {

        $userActivationAccountService = new UserActivationAccountService(
            $request,
            $this->response,
            $this->managerRegistry
        );

        return $userActivationAccountService->activate($hash)->make();

    }

    /**
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/user/auth', methods: 'POST')]
    public function auth(Request $request, ValidatorInterface $validator): JsonResponse
    {

        $userAuthorizationService = new UserAuthorizationService($request, $this->response, $this->managerRegistry);

        return $userAuthorizationService->authorize($validator)->make();

    }

}