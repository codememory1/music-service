<?php

namespace App\Controllers\V1;

use App\Services\Password\RecoveryService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use JetBrains\PhpStorm\NoReturn;
use ReflectionException;

/**
 * Class PasswordRecoveryController
 *
 * @package App\Controllers\V1
 *
 * @author  Danil
 */
class PasswordRecoveryController extends AbstractAuthorizationController
{

    /**
     * @var RecoveryService
     */
    private RecoveryService $passwordRecoveryService;

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

        /** @var RecoveryService $passwordRecoveryService */
        $passwordRecoveryService = $this->getService('Password\Recovery');
        $this->passwordRecoveryService = $passwordRecoveryService;

    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    #[NoReturn]
    public function restoreRequest(): void
    {

        $this->execIfNotLoggedIn(function () {
            // We send a message to the mail with a password recovery code
            $sendResponse = $this->passwordRecoveryService->restoreRequest($this->validatorManager());

            $this->response->json($sendResponse->getResponse(), $sendResponse->getStatus());
        });

    }

    /**
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function change(): void
    {

        $this->execIfNotLoggedIn(function () {
            // Change password and delete request record
            $changeResponse = $this->passwordRecoveryService->change($this->validatorManager());

            $this->response->json($changeResponse->getResponse(), $changeResponse->getStatus());
        });

    }

    /**
     * @param callable $callback
     *
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function execIfNotLoggedIn(callable $callback): void
    {

        if ($this->isAuth()) {
            // Returns the answer, so that to recover the password, the user must not be auto-canceled
            $apiResponse = $this->apiResponse->create(400, [
                $this->translationsFromDb->getTranslationByKey('passwordRecovery@withoutAuth')
            ]);

            $this->response->json($apiResponse->getResponse(), $apiResponse->getStatus());
        } else {
            call_user_func($callback);
        }

    }

}