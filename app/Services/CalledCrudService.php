<?php

namespace App\Services;

use App\Services\Auth\AuthorizationService;
use App\Services\Interfaces\CalledCrudInterface;
use App\Services\Translation\DataService;
use ArgumentCountError;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use JetBrains\PhpStorm\NoReturn;
use ReflectionException;

/**
 * Class CalledCrudService
 *
 * @package App\Services
 *
 * @author  Danil
 */
class CalledCrudService extends AbstractApiService implements CalledCrudInterface
{

    /**
     * @var string|null
     */
    private ?string $serviceName = null;

    /**
     * @var AuthorizationService|null
     */
    private ?AuthorizationService $authorizationService = null;

    /**
     * @var DataService|null
     */
    private ?DataService $translationDataService = null;

    /**
     * @var bool
     */
    private bool $initialized = false;

    /**
     * @var array
     */
    private array $arguments = [];

    /**
     * @var array
     */
    private array $checks = [
        'add_argument_auth_user' => false,
        'roles'                  => [],
        'access_right'           => false,
        'is_auth'                => false
    ];

    /**
     * @param string               $serviceName
     * @param AuthorizationService $authorizationService
     * @param DataService          $translationDataService
     *
     * @return void
     */
    public function init(string $serviceName, AuthorizationService $authorizationService, DataService $translationDataService): void
    {

        $this->serviceName = $serviceName;
        $this->authorizationService = $authorizationService;
        $this->translationDataService = $translationDataService;
        $this->initialized = true;

    }

    /**
     * @inheritDoc
     */
    public function addArgument(mixed $value, bool $toFirstPosition = false): CalledCrudInterface
    {

        if ($toFirstPosition) {
            array_unshift($this->arguments, $value);
        } else {
            $this->arguments[] = $value;
        }

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function addArgumentAuthUser(): CalledCrudInterface
    {

        $this->checks['add_argument_auth_user'] = true;

        return $this;

    }


    /**
     * @inheritDoc
     */
    public function checkRole(string ...$roles): CalledCrudInterface
    {

        $this->checks['is_auth'] = true;
        $this->checks['roles'] += $roles;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function checkAccessRight(string $rightName): CalledCrudInterface
    {

        $this->checks['is_auth'] = true;
        $this->checks['access_right'] = $rightName;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function checkIsAuth(): CalledCrudInterface
    {

        $this->checks['is_auth'] = true;

        return $this;

    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function response(): void
    {

        if (!$this->initialized) {
            throw new ArgumentCountError('Few arguments passed to init method');
        }

        $authorizedUser = $this->authorizationService->isAuth($this->getEntityManager());
        $authorizedUserRole = null;

        if (false !== $authorizedUser) {
            $authorizedUserRole = $authorizedUser->getRoleData()->getName();
        }

        if ($this->checks['add_argument_auth_user']) {
            $this->addArgument($authorizedUser, true);
        }

        // Authorization check
        if ($this->checks['is_auth'] && !$authorizedUser) {
            $this->makeApiResponse(401, 'security@notAuth');
        }

        // Checking role rights
        if (false !== $this->checks['access_right']) {
            $finedAccessRight = false;

            foreach ($authorizedUser->getRoleData()->getRights() as $right) {
                if ($right->getAccessRightName()->getName() === $this->checks['access_right']) {
                    $finedAccessRight = true;
                }
            }

            if (false !== $this->checks['access_right'] && !$finedAccessRight) {
                $this->makeApiResponse(403, 'security@invalidRole');
            }
        }

        // Role check
        if ([] !== $this->checks['roles'] && !in_array($authorizedUserRole, $this->checks['roles'])) {
            $this->makeApiResponse(403, 'security@invalidRole');
        }

        /** @var AbstractCrudService $crudService */
        $crudService = $this->getService($this->serviceName);
        $crudServiceResponse = $crudService->make(...$this->arguments)->getResponseApiCollector();

        $this->response->json($crudServiceResponse->getResponse(), $crudServiceResponse->getStatus());

    }

    /**
     * @param int    $status
     * @param string $translationKey
     *
     * @return void
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[NoReturn]
    private function makeApiResponse(int $status, string $translationKey): void
    {

        $apiResponse = $this->apiResponse->create($status, [
            $this->translationDataService->getTranslationByKey($translationKey)
        ]);

        $this->response->json($apiResponse->getResponse(), $status);

    }

}