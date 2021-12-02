<?php

namespace App\Services\Auth;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class IdentificationService
 *
 * @package App\Services\Auth
 *
 * @author  Danil
 */
class IdentificationService extends AbstractApiService
{

    /**
     * @param UserRepository $userRepository
     *
     * @return bool|UserEntity
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    final public function identify(UserRepository $userRepository): bool|UserEntity
    {

        $inputUsernameOrEmail = $this->request->post()->get('username');

        // Checking the existence of a user by the input email or username
        return $userRepository->findOneByOr([
            'email'    => $inputUsernameOrEmail,
            'username' => $inputUsernameOrEmail,
        ]);

    }

    /**
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function getResponse(): ResponseApiCollectorService
    {

        return $this->createApiResponse(400, 'auth@badIdentification');

    }

}