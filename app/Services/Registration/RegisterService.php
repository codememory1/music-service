<?php

namespace App\Services\Registration;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Event\Exceptions\EventExistException;
use Codememory\Components\Event\Exceptions\EventNotExistException;
use Codememory\Components\Event\Exceptions\EventNotImplementInterfaceException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager as ValidatorManager;
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
     * @param ValidatorManager       $validatorManager
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService
     * @throws BuilderNotCurrentSectionException
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws InvalidTimezoneException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function register(ValidatorManager $validatorManager, EntityManagerInterface $entityManager): ResponseApiCollectorService
    {

        /** @var RegistrationValidationService $registrationValidationService */
        $registrationValidationService = $this->getService('Registration\RegistrationValidation');

        /** @var AccountCreatorService $accountCreatorService */
        $accountCreatorService = $this->getService('Registration\AccountCreator');

        // Result of all registration validation
        $validationResult = $registrationValidationService->validate($validatorManager, $entityManager);

        // Check the existence of mail and if it is not yet activated
        // We update the activation token and send the message to the mail again
        if (true !== $validationResult && $validationResult->getType() === RegistrationValidationService::EXIST_NO_ACTIVATED_MAIL) {
            return $this->refreshActivationToken($entityManager);
        }

        // If the validation passed, we create an account.
        // Otherwise, it will return a response about the verification problem
        return $validationResult === true ? $accountCreatorService->createAccount($entityManager) : $validationResult;

    }

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService
     * @throws BuilderNotCurrentSectionException
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function refreshActivationToken(EntityManagerInterface $entityManager): ResponseApiCollectorService
    {

        /** @var RefresherActivationTokenService $refresherActivationTokenService */
        $refresherActivationTokenService = $this->getService('Registration\RefresherActivationToken');

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(UserEntity::class);
        $finedUser = $userRepository->findOne([
            'email' => $this->request->post()->get('email')
        ]);

        // We update the activation token and return a response about a successful update
        return $refresherActivationTokenService->refresh($entityManager, $finedUser)->getResponse();

    }

}