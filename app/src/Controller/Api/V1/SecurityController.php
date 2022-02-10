<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\DTO\AuthorizationDTO;
use App\DTO\RegistrationDTO;
use App\Exception\UndefinedClassForDTOException;
use App\Service\RequestDataService;
use App\Service\Security\Auth\UserAuthorizationService;
use App\Service\Security\Register\UserActivationAccountService;
use App\Service\Security\Register\UserRegisterService;
use Doctrine\ORM\NonUniqueResultException;
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
     * @param RequestDataService       $requestDataService
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return JsonResponse
     * @throws NonUniqueResultException
     * @throws UndefinedClassForDTOException
     */
    #[Route('/user/register', methods: 'POST')]
    public function register(Request $request, RequestDataService $requestDataService, EventDispatcherInterface $eventDispatcher): JsonResponse
    {

        /** @var UserRegisterService $service */
        $service = $this->getCollectedService($request, UserRegisterService::class);
        $registrationDTO = new RegistrationDTO($requestDataService, $this->managerRegistry);

        return $service->register($registrationDTO, $this->validator, $eventDispatcher)->make();

    }

    /**
     * @param Request $request
     * @param string  $token
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/user/activate-account/{token<[^\.]+>}', methods: 'GET')]
    public function activateAccount(Request $request, string $token): JsonResponse
    {

        /** @var UserActivationAccountService $service */
        $service = $this->getCollectedService($request, UserActivationAccountService::class);

        return $service->activate($token)->make();

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/user/auth', methods: 'POST')]
    public function auth(Request $request, RequestDataService $requestDataService): JsonResponse
    {

        /** @var UserAuthorizationService $service */
        $service = $this->getCollectedService($request, UserAuthorizationService::class);
        $authorizationDTO = new AuthorizationDTO($requestDataService, $this->managerRegistry);

        $authorizationDTO->setClientIp($request->getClientIp());

        return $service->authorize($authorizationDTO, $this->validator)->make();

    }

}