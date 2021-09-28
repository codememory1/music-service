<?php

namespace App\Controllers\Api\V1;

use App\Services\Registration\RegisterService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\JsonParser\Exceptions\JsonErrorException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\ResponseInterface;
use JetBrains\PhpStorm\NoReturn;
use Kernel\Controller\AbstractController;
use ReflectionException;

/**
 * Class RegisterController
 *
 * @package App\Controllers\Api\v1
 *
 * @author  Danil
 */
class RegisterController extends AbstractController
{

    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @throws BuilderNotCurrentSectionException
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var ResponseInterface $response */
        $response = $this->get('response');
        $this->response = $response;

        $this->em = $this->getDatabase()->getEntityManager();

    }

    /**
     * @throws QueryNotGeneratedException
     * @throws JsonErrorException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    #[NoReturn]
    public function register(): void
    {

        /** @var RegisterService $registerService */
        $registerService = $this->getService('Registration\Register');

        // Receiving a response about user registration
        $registrationResponse = $registerService->register($this->validatorManager(), $this->em);

        $this->response->json($registrationResponse->getResponse(), $registrationResponse->getStatus());

    }

}