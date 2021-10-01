<?php

namespace App\Services\Auth;

use App\Orm\Entities\UserEntity;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class AuthenticationService
 *
 * @package App\Services\Auth
 *
 * @author  Danil
 */
class AuthenticationService extends AbstractApiService
{

    /**
     * @param UserEntity $userEntity
     *
     * @return ResponseApiCollectorService|bool
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    final public function authenticate(UserEntity $userEntity): ResponseApiCollectorService|bool
    {

        /** @var VerificationsService $verificationsService */
        $verificationsService = $this->getService('Auth\Verifications');

        // Verifying the password of an identified user
        if (true !== $verificationResponse = $verificationsService->passwordVerification($userEntity)) {
            return $verificationResponse;
        }

        return true;

    }

}