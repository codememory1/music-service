<?php

namespace App\Services\Auth;

use App\Orm\Entities\UserEntity;
use App\Services\PasswordHashingService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Services\AbstractService;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\RequestInterface;

/**
 * Class VerificationsService
 *
 * @package App\Services\Auth
 *
 * @author  Danil
 */
class VerificationsService extends AbstractService
{

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
     * @param UserEntity $userEntity
     *
     * @return ResponseApiCollectorService|bool
     */
    public function passwordVerification(UserEntity $userEntity): ResponseApiCollectorService|bool
    {

        /** @var PasswordHashingService $passwordHashing */
        $passwordHashing = $this->get('password-hashing');

        // Comparing the password hash of the authenticated user with the input password
        if (!$passwordHashing->compare($this->request->post()->get('password'), $userEntity->getPassword())) {
            return $this->apiResponse->create(400, [
                $this->translation->getTranslationActiveLang('auth.invalidPassword')
            ]);
        }

        return true;

    }

    /**
     * @param UserEntity $userEntity
     *
     * @return ResponseApiCollectorService|bool
     */
    public function statusVerification(UserEntity $userEntity): ResponseApiCollectorService|bool
    {

        // Checking the status of an identified user for non-activation
        if (0 === (int) $userEntity->getStatus()) {
            return $this->apiResponse->create(400, [
                $this->translation->getTranslationActiveLang('auth.emailNotActivate')
            ]);
        }

        return true;

    }

}