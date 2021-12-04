<?php

namespace App\Services\Registration;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\Pack\DatabasePack;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager as ValidatorManager;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use ReflectionException;

/**
 * Class RegisterService
 *
 * @package App\Services
 *
 * @author  Danil
 */
class RegisterService extends AbstractApiService
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param ServiceProviderInterface $serviceProvider
     * @param DatabasePack             $databasePack
     */
    public function __construct(ServiceProviderInterface $serviceProvider, DatabasePack $databasePack)
    {

        parent::__construct($serviceProvider, $databasePack);

        /** @var UserRepository $userRepository */
        $userRepository = $this->getRepository(UserEntity::class);
        $this->userRepository = $userRepository;

    }

    /**
     * @param ValidatorManager $validatorManager
     *
     * @return ResponseApiCollectorService
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function register(ValidatorManager $validatorManager): ResponseApiCollectorService
    {

        /** @var RegistrationValidationService $registrationValidationService */
        $registrationValidationService = $this->getService('Registration\RegistrationValidation');

        /** @var AccountCreatorService $accountCreatorService */
        $accountCreatorService = $this->getService('Registration\AccountCreator');

        // Result of all registration validation
        $validationResult = $registrationValidationService->validate($validatorManager, $this->userRepository);

        // Check the existence of mail and if it is not yet activated
        // We update the activation token and send the message to the mail again
        if (true !== $validationResult && $validationResult->getType() === RegistrationValidationService::EXIST_NO_ACTIVATED_MAIL) {
            return $this->refreshActivationToken();
        }

        // If the validation passed, we create an account.
        // Otherwise, it will return a response about the verification problem
        return $validationResult === true ? $accountCreatorService->createAccount($this->userRepository) : $validationResult;

    }

    /**
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function refreshActivationToken(): ResponseApiCollectorService
    {

        /** @var RefresherActivationTokenService $refresherActivationTokenService */
        $refresherActivationTokenService = $this->getService('Registration\RefresherActivationToken');
        $finedUser = $this->userRepository->findOne([
            'email' => $this->request->post()->get('email')
        ]);

        // We update the activation token and return a response about a successful update
        return $refresherActivationTokenService->refresh($finedUser)->getResponse();

    }

}