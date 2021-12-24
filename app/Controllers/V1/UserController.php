<?php

namespace App\Controllers\V1;

use App\Orm\Dto\UserDto;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use ReflectionException;

/**
 * Class UserController
 *
 * @package App\Controllers\V1
 *
 * @author  Danil
 */
class UserController extends AbstractAuthorizationController
{

    /**
     * @return void
     * @throws StatementNotSelectedException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    public function showCurrentUser(): void
    {

        if (false != $authorizedUser = $this->isAuthWithResponse()) {
            $userDto = new UserDto($authorizedUser);

            $this->response->json($userDto->getTransformedData());
        }

    }

}