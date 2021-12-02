<?php

namespace App\Services\Auth;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\Enums\StatusEnum;
use App\Services\AbstractApiService;
use App\Services\PasswordHashingService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class VerificationsService
 *
 * @package App\Services\Auth
 *
 * @author  Danil
 */
class VerificationsService extends AbstractApiService
{

    /**
     * @param UserEntity $userEntity
     *
     * @return ResponseApiCollectorService|bool
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    public function passwordVerification(UserEntity $userEntity): ResponseApiCollectorService|bool
    {

        /** @var PasswordHashingService $passwordHashing */
        $passwordHashing = $this->get('password-hashing');

        // Comparing the password hash of the authenticated user with the input password
        if (!$passwordHashing->compare($this->request->post()->get('password'), $userEntity->getPassword())) {
            return $this->createApiResponse(400, 'security@wrongPassword');
        }

        return true;

    }

    /**
     * @param UserEntity $userEntity
     *
     * @return ResponseApiCollectorService|bool
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function statusVerification(UserEntity $userEntity): ResponseApiCollectorService|bool
    {

        // Checking the status of an identified user for non-activation
        if (StatusEnum::NOT_ACTIVATED === (int) $userEntity->getStatus()) {
            return $this->createApiResponse(400, 'auth@emailNotActivate');
        }

        return true;

    }

}