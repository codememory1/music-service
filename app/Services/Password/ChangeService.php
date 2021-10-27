<?php

namespace App\Services\Password;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\AbstractApiService;
use App\Services\PasswordHashingService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class ChangeService
 *
 * @package App\Services\Password
 *
 * @author  Codememory
 */
class ChangeService extends AbstractApiService
{

    /**
     * @param int                    $userId
     * @param EntityManagerInterface $entityManager
     *
     * @return void
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function change(int $userId, EntityManagerInterface $entityManager): void
    {

        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(UserEntity::class);

        /** @var PasswordHashingService $passwordHashing */
        $passwordHashing = $this->get('password-hashing');

        // Hashing and updating the user's password
        $userRepository->update([
            'password' => $passwordHashing->encode($this->request->post()->get('password'))
        ], [
            'id' => $userId
        ]);

    }

}