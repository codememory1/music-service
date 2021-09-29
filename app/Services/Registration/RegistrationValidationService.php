<?php

namespace App\Services\Registration;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\JsonParser\Exceptions\JsonErrorException;
use Codememory\Components\Services\AbstractService;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Components\Validator\Manager as ValidatorManager;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\RequestInterface;
use Codememory\HttpFoundation\Request\Request;
use ReflectionException;

/**
 * Class RegistrationValidationService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class RegistrationValidationService extends AbstractService
{

    public const EXIST_NO_ACTIVATED_MAIL = 'exist-not-activated-email';

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var ResponseApiCollectorService
     */
    private ResponseApiCollectorService $apiResponse;

    /**
     * @var TranslationInterface
     */
    private TranslationInterface $translation;

    /**
     * @param ServiceProviderInterface $serviceProvider
     */
    public function __construct(ServiceProviderInterface $serviceProvider)
    {

        parent::__construct($serviceProvider);

        /** @var RequestInterface $request */
        $request = $this->get('request');
        $this->request = $request;

        /** @var ResponseApiCollectorService $apiResponse */
        $apiResponse = $this->get('api-response');
        $this->apiResponse = $apiResponse;

        /** @var TranslationInterface $translation */
        $translation = $this->get('translator');
        $this->translation = $translation;

    }

    /**
     * @param ValidatorManager       $validatorManager
     * @param EntityManagerInterface $entityManager
     *
     * @return ResponseApiCollectorService|bool
     * @throws JsonErrorException
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    final public function validate(ValidatorManager $validatorManager, EntityManagerInterface $entityManager): ResponseApiCollectorService|bool
    {

        /** @var RegistrationInputValidationService $inputValidationService */
        $inputValidationService = $this->getService('Registration\RegistrationInputValidation');

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(UserEntity::class);

        // Checking the result of validation of input data
        if (true !== $validationResult = $inputValidationService->validate($validatorManager, $this->request)) {
            return $validationResult;
        }

        // Checking the existence of a user with this email and if it is already activated
        if ($this->existNotActivatedEmail($userRepository, $this->request)) {
            return $this->apiResponse->setType(self::EXIST_NO_ACTIVATED_MAIL)->create(400, [
                $this->translation->getTranslationActiveLang('register.accountWithEmailExist')
            ]);
        }

        // Checking for the existence of verified mail
        if ($this->existActivatedEmail($userRepository, $this->request)) {
            return $this->apiResponse->create(400, [
                $this->translation->getTranslationActiveLang('register.accountWithEmailExist')
            ]);
        }

        return true;

    }

    /**
     * @param UserRepository $userRepository
     * @param Request        $request
     *
     * @return bool
     * @throws JsonErrorException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     * @throws NotSelectedStatementException
     */
    private function existNotActivatedEmail(UserRepository $userRepository, Request $request): bool
    {

        // We are looking for a record by input Email
        $finedUser = $userRepository->findOne([
            'email' => $request->post()->get('email')
        ]);

        return false !== $finedUser && (int) $finedUser->getStatus() === 0;

    }

    /**
     * @param UserRepository $userRepository
     * @param Request        $request
     *
     * @return bool
     * @throws JsonErrorException
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    private function existActivatedEmail(UserRepository $userRepository, Request $request): bool
    {

        // We are looking for a record by input Email
        $finedUser = $userRepository->findOne([
            'email' => $request->post()->get('email')
        ]);

        return false !== $finedUser && (int) $finedUser->getStatus() === 1;

    }

}