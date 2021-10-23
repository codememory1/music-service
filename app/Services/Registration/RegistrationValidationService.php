<?php

namespace App\Services\Registration;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\Enums\StatusEnum;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager as ValidatorManager;
use ReflectionException;

/**
 * Class RegistrationValidationService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class RegistrationValidationService extends AbstractApiService
{

    public const EXIST_NO_ACTIVATED_MAIL = 'exist-not-activated-email';

    /**
     * @param ValidatorManager       $validatorManager
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService|bool
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function validate(ValidatorManager $validatorManager, EntityManagerInterface $entityManager): ResponseApiCollectorService|bool
    {

        /** @var RegistrationInputValidationService $inputValidationService */
        $inputValidationService = $this->getService('Registration\RegistrationInputValidation');

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(UserEntity::class);

        // Checking the result of validation of input data
        if (true !== $validationResult = $inputValidationService->validate($validatorManager)) {
            return $validationResult;
        }

        // Checking the existence of a user with this email and if it is already activated
        if ($this->existNotActivatedEmail($userRepository)) {
            return $this->createApiResponse(400, 'register.accountWithEmailExist')->setType(self::EXIST_NO_ACTIVATED_MAIL);
        }

        // Checking for the existence of verified mail
        if ($this->existActivatedEmail($userRepository)) {
            return $this->createApiResponse(400, 'register.accountWithEmailExist');
        }

        return true;

    }

    /**
     * @param UserRepository $userRepository
     *
     * @return bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function existNotActivatedEmail(UserRepository $userRepository): bool
    {

        // We are looking for a record by input Email
        $finedUser = $userRepository->findOne([
            'email' => $this->request->post()->get('email')
        ]);

        return false !== $finedUser && (int) $finedUser->getStatus() === StatusEnum::NOT_ACTIVATED;

    }

    /**
     * @param UserRepository $userRepository
     *
     * @return bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function existActivatedEmail(UserRepository $userRepository): bool
    {

        // We are looking for a record by input Email
        $finedUser = $userRepository->findOne([
            'email' => $this->request->post()->get('email')
        ]);

        return false !== $finedUser && (int) $finedUser->getStatus() === StatusEnum::ACTIVATED;

    }

}