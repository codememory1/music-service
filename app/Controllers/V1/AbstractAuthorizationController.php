<?php

namespace App\Controllers\V1;

use App\Orm\Entities\UserEntity;
use App\Services\Auth\AuthorizationService;
use App\Services\CalledCrudService;
use App\Services\Interfaces\CalledCrudInterface;
use App\Services\ResponseApiCollectorService;
use App\Services\Translation\DataService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\ResponseInterface;
use ReflectionException;

/**
 * Class AbstractAuthorizationController
 *
 * @package App\Controllers\Api\V1
 *
 * @author  Danil
 */
abstract class AbstractAuthorizationController extends AbstractApiController
{

    /**
     * @var AuthorizationService
     */
    private AuthorizationService $authorizationService;

    /**
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * @var ResponseApiCollectorService
     */
    protected ResponseApiCollectorService $apiResponse;

    /**
     * @var TranslationInterface
     */
    protected TranslationInterface $translation;

    /**
     * @var DataService
     */
    protected DataService $translationsFromDb;

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @throws BuilderNotCurrentSectionException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var AuthorizationService $authorizationService */
        $authorizationService = $this->getService('Auth\Authorization');
        $this->authorizationService = $authorizationService;

        /** @var ResponseInterface $response */
        $response = $this->get('response');
        $this->response = $response;

        $this->em = $this->getDatabase()->getEntityManager();

        /** @var ResponseApiCollectorService $apiResponse */
        $apiResponse = $this->get('api-response');
        $this->apiResponse = $apiResponse;

        /** @var TranslationInterface $translation */
        $translation = $this->get('translator');
        $this->translation = $translation;

        /** @var DataService $translationsFromDb */
        $translationsFromDb = $this->getService('Translation\Data');
        $this->translationsFromDb = $translationsFromDb;

    }

    /**
     * Check user authorization, if authorized, return its entity,
     * otherwise false
     *
     * @return UserEntity|bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    protected function isAuthWithData(): UserEntity|bool
    {

        return $this->authorizationService->isAuth($this->getDatabase()->getEntityManager());

    }

    /**
     * Check user authorization
     *
     * @return bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    protected function isAuth(): bool
    {

        return false !== $this->isAuthWithData();

    }

    /**
     * @param string $serviceName
     *
     * @return CalledCrudInterface
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    protected function initCrud(string $serviceName): CalledCrudInterface
    {

        /** @var CalledCrudService $calledCrudService */
        $calledCrudService = $this->getService('CalledCrud');

        $calledCrudService->init(
            $serviceName,
            $this->authorizationService,
            $this->translationsFromDb
        );

        return $calledCrudService;

    }

}