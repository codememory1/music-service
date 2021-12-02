<?php

namespace App\Services\Password;

use App\Orm\Entities\PasswordResetEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\PasswordResetRepository;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Services\Translation\DataService;
use App\Tasks\PasswordRecoveryRequestTask;
use App\Validations\Security\PasswordRecovery\RestoreRequestValidation;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class RestoreRequestService
 *
 * @package App\Services\PasswordReset
 *
 * @author  Danil
 */
class RestoreRequestService extends AbstractApiService
{

    /**
     * @param ValidationManager      $validationManager
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function send(ValidationManager $validationManager, EntityManagerInterface $entityManager): ResponseApiCollectorService
    {

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(UserEntity::class);
        $creationValidationManager = $this->inputValidation($validationManager);
        $restoredUser = $userRepository->findOne([
            'email' => $this->request->post()->get('email')
        ]);

        // Input validation
        if (!$creationValidationManager->isValidation()) {
            return $this->apiResponse->create(400, $creationValidationManager->getErrors());
        }

        // User Existence Check
        if (!$restoredUser) {
            return $this->createApiResponse(404, 'common@userNotExist');
        }

        return $this->sendHandler($entityManager, $restoredUser);

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new RestoreRequestValidation(), $this->request->post()->all());

    }

    /**
     * @param UserEntity $userEntity
     *
     * @return PasswordResetEntity
     */
    private function getCollectedPasswordResetEntity(UserEntity $userEntity): PasswordResetEntity
    {

        $passwordResetEntity = new PasswordResetEntity();
        $passwordResetEntity
            ->setUserId($userEntity->getId())
            ->setCode($this->generateCode());

        return $passwordResetEntity;

    }

    /**
     * @return int
     */
    private function generateCode(): int
    {

        return rand(100000, 999999);

    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserEntity             $userEntity
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    private function sendHandler(EntityManagerInterface $entityManager, UserEntity $userEntity): ResponseApiCollectorService
    {

        /** @var PasswordResetRepository $passwordResetRepository */
        $passwordResetRepository = $entityManager->getRepository(PasswordResetEntity::class);
        $passwordResetEntity = $this->getCollectedPasswordResetEntity($userEntity);

        /** @var DataService $translationsFromDb */
        $translationsFromDb = $this->getService('Translation\Data');

        // We check the existence of a record with the code,
        // if it does not exist, then add it, otherwise we update it
        if (!$passwordResetRepository->findOne(['user_id' => $userEntity->getId()])) {
            $entityManager->commit($passwordResetEntity)->flush();
        } else {
            $passwordResetEntity->setCode($this->generateCode());
            $passwordResetRepository->update([
                'code' => $passwordResetEntity->getCode()
            ], [
                'user_id' => $userEntity->getId()
            ]);
        }

        // Creating a task for the message sending queue
        $this->dispatchJob(PasswordRecoveryRequestTask::class, [
            'email'   => $userEntity->getEmail(),
            'code'    => $passwordResetEntity->getCode(),
            'subject' => $translationsFromDb->getTranslationByKey('passwordRecovery')
        ]);

        return $this->createApiResponse(200, 'passwordRecovery@successRestoreRequest');

    }

}