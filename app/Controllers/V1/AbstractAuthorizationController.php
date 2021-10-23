<?php

namespace App\Controllers\V1;

use App\Orm\Entities\UserEntity;
use App\Services\Auth\AuthorizationService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\ResponseInterface;
use JetBrains\PhpStorm\NoReturn;
use Kernel\Controller\AbstractController;
use ReflectionException;

/**
 * Class AbstractAuthorizationController
 *
 * @package App\Controllers\Api\V1
 *
 * @author  Danil
 */
abstract class AbstractAuthorizationController extends AbstractController
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
     * Check the authorization of the user, if authorized to return his entity,
     * otherwise return a response with 401 status
     *
     * @return UserEntity
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    protected function isAuthWithResponse(): UserEntity
    {

        if (false === $authUser = $this->isAuthWithData()) {
            $apiResponse = $this->apiResponse->create(401, [
                $this->translation->getTranslationActiveLang('security.unauthorized')
            ]);

            $this->response->json($apiResponse->getResponse(), $apiResponse->getStatus());
        }

        return $authUser;

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
     * Check if not the role of the authorized user corresponds to specific roles
     *
     * @param UserEntity $userEntity
     * @param string[]   $roles
     *
     * @return bool
     */
    protected function isNotRoles(UserEntity $userEntity, array $roles): bool
    {

        if (in_array($userEntity->getRole(), $roles)) {
            $apiResponse = $this->responseIncorrectRole();

            $this->response->json($apiResponse->getResponse(), $apiResponse->getStatus());
        }

        return true;

    }

    /**
     * Check if the role of the authorized user corresponds to specific roles
     *
     * @param UserEntity $userEntity
     * @param string[]   $roles
     *
     * @return bool
     */
    protected function isRoles(UserEntity $userEntity, array $roles): bool
    {

        if (!in_array($userEntity->getRole(), $roles)) {
            $apiResponse = $this->responseIncorrectRole();

            $this->response->json($apiResponse->getResponse(), $apiResponse->getStatus());
        }

        return true;

    }

    /**
     * @param UserEntity $userEntity
     * @param string     $rightName
     *
     * @return bool
     */
    protected function isExistRight(UserEntity $userEntity, string $rightName): bool
    {

        foreach ($userEntity->getRoleData()->getRights() as $right) {
            if ($right->getAccessRightName()->getName() === $rightName) {
                return true;
            }
        }

        $apiResponse = $this->responseIncorrectRole();

        $this->response->json($apiResponse->getResponse(), $apiResponse->getStatus());

    }

    /**
     * Throw out a reply with a message from translations
     *
     * @param int    $status
     * @param string $translationKey
     *
     * @return void
     */
    #[NoReturn]
    protected function responseWithTranslation(int $status, string $translationKey): void
    {

        $apiResponse = $this->apiResponse->create($status, [
            $this->translation->getTranslationActiveLang($translationKey)
        ]);

        $this->response->json($apiResponse->getResponse(), $status);

    }

    /**
     * @return ResponseApiCollectorService
     */
    private function responseIncorrectRole(): ResponseApiCollectorService
    {

        return $this->apiResponse->create(403, [
            $this->translation->getTranslationActiveLang('security.incorrectRole')
        ]);

    }

}