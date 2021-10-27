<?php

namespace App\Services\Password;

use App\Orm\Repositories\PasswordResetRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class RemoveCodeService
 *
 * @package App\Services\Password
 *
 * @author  Danil
 */
class RemoveCodeService
{

    /**
     * @param int                     $code
     * @param PasswordResetRepository $passwordResetRepository
     *
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function remove(int $code, PasswordResetRepository $passwordResetRepository): void
    {

        $passwordResetRepository->delete([
            'code' => $code
        ]);

    }

}