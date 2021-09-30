<?php

namespace App\Services\Registration;

use App\Events\UserRegisterEventEvent;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\PasswordHashingService;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\ActivationTokenService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Event\Exceptions\EventExistException;
use Codememory\Components\Event\Exceptions\EventNotExistException;
use Codememory\Components\Event\Exceptions\EventNotImplementInterfaceException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\AbstractService;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\RequestInterface;
use ReflectionException;

/**
 * Class AccountCreatorService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class AccountCreatorService extends AbstractService
{

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @param ServiceProviderInterface $serviceProvider
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var RequestInterface $request */
        $request = $this->get('request');
        $this->request = $request;

    }

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService
     * @throws BuilderNotCurrentSectionException
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws InvalidTimezoneException
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    final public function createAccount(EntityManagerInterface $entityManager): ResponseApiCollectorService
    {

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(UserEntity::class);
        $collectedUserEntity = $this->getCollectedUserEntity($userRepository);

        return $this->pushUser($entityManager, $collectedUserEntity);

    }

    /**
     * @param UserRepository $usersRepository
     *
     * @return UserEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws InvalidTimezoneException
     */
    private function getCollectedUserEntity(UserRepository $usersRepository): UserEntity
    {

        /** @var PasswordHashingService $passwordHashing */
        $passwordHashing = $this->get('password-hashing');
        $inputData = $this->request->post();

        /** @var ActivationTokenService $activationToken */
        $activationToken = $this->get('activation-token');

        $userEntity = new UserEntity();
        $userEntity
            ->setUserid($usersRepository->getCountUsers() + 1 . rand(1000, 9999))
            ->setName($inputData->get('name'))
            ->setEmail($inputData->get('email'))
            ->setUsername($inputData->get('email'))
            ->setPassword($passwordHashing->encode($inputData->get('password')))
            ->setActivationToken($activationToken->encode());

        return $userEntity;

    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserEntity             $userEntity
     *
     * @return ResponseApiCollectorService
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws BuilderNotCurrentSectionException
     * @throws ReflectionException
     */
    private function pushUser(EntityManagerInterface $entityManager, UserEntity $userEntity): ResponseApiCollectorService
    {

        /** @var ResponseApiCollectorService $apiResponse */
        $apiResponse = $this->get('api-response');

        /** @var TranslationInterface $translation */
        $translation = $this->get('translator');

        // Saving a user to the database
        $entityManager->commit($userEntity)->flush();

        // Raising the user registration event
        $this->dispatchEvent(UserRegisterEventEvent::class, [
            $this->get('mailer'),
            $userEntity
        ]);

        return $apiResponse->create(200, [
            $translation->getTranslationActiveLang('register.successRegister')
        ]);

    }

}