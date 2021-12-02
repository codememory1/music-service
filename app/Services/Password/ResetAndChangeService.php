<?php

namespace App\Services\Password;

use App\Orm\Entities\PasswordResetEntity;
use App\Orm\Repositories\PasswordResetRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\Security\PasswordRecovery\ChangeValidation;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class ResetAndChangeService
 *
 * @package App\Services\PasswordReset
 *
 * @author  Danil
 */
class ResetAndChangeService extends AbstractApiService
{

    /**
     * @param ValidationManager      $validationManager
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     * @throws ServiceNotExistException
     */
    final public function change(ValidationManager $validationManager, EntityManagerInterface $entityManager): ResponseApiCollectorService
    {

        $code = $this->request->post()->get('code');
        $inputValidation = $this->inputValidation($validationManager);

        /** @var PasswordResetRepository $passwordResetRepository */
        $passwordResetRepository = $entityManager->getRepository(PasswordResetEntity::class);

        /** @var ChangeService $passwordChangeService */
        $passwordChangeService = $this->getService('Password\Change');

        // Validating input data when changing a password
        if (!$inputValidation->isValidation()) {
            return $this->apiResponse->create(400, $inputValidation->getErrors());
        }

        // Checking for Code Existence
        if (false === $finedRecordByCode = $this->existCode($code, $passwordResetRepository)) {
            return $this->createApiResponse(400, 'passwordRecovery@invalidCode');
        }

        // Changing the password in the database
        $passwordChangeService->change($finedRecordByCode->getUserId(), $entityManager);

        // Removing the code
        (new RemoveCodeService())->remove($code, $passwordResetRepository);

        return $this->createApiResponse(200, 'passwordRecovery@successRecovery');

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new ChangeValidation(), $this->request->all());

    }

    /**
     * @param mixed                   $code
     * @param PasswordResetRepository $passwordResetRepository
     *
     * @return bool|PasswordResetEntity
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function existCode(mixed $code, PasswordResetRepository $passwordResetRepository): bool|PasswordResetEntity
    {

        return $passwordResetRepository->findOne(['code' => $code]);

    }

}