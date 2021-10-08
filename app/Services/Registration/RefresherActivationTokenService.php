<?php

namespace App\Services\Registration;

use App\Events\UserRegisterEvent;
use App\Orm\Entities\ActivationTokenEntity;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\ActivationTokenRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\ActivationTokenService;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\Event\Exceptions\EventExistException;
use Codememory\Components\Event\Exceptions\EventNotExistException;
use Codememory\Components\Event\Exceptions\EventNotImplementInterfaceException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use ReflectionException;

/**
 * Class RefresherActivationTokenService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class RefresherActivationTokenService extends AbstractApiService
{

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserEntity             $userEntity
     *
     * @return RefresherActivationTokenService
     * @throws BuilderNotCurrentSectionException
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    final public function refresh(EntityManagerInterface $entityManager, UserEntity $userEntity): RefresherActivationTokenService
    {

        /** @var ActivationTokenRepository $activationTokenRepository */
        $activationTokenRepository = $entityManager->getRepository(ActivationTokenEntity::class);

        // Change the user activation token and return the token activation entity
        $activationTokenEntity = $this->changeToken($activationTokenRepository, $userEntity);

        // Raising the user registration event
        $this->dispatchEvent(UserRegisterEvent::class, [
            $this->get('mailer'),
            $userEntity,
            $activationTokenEntity
        ]);

        return $this;

    }

    /**
     * @return ResponseApiCollectorService
     */
    final public function getResponse(): ResponseApiCollectorService
    {

        return $this->createApiResponse(200, 'register.successRegister');

    }

    /**
     * @param ActivationTokenRepository $activationTokenRepository
     * @param UserEntity                $userEntity
     *
     * @return ActivationTokenEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    private function changeToken(ActivationTokenRepository $activationTokenRepository, UserEntity $userEntity): ActivationTokenEntity
    {

        /** @var ActivationTokenService $activationTokenService */
        $activationToken = $this->get('activation-token');

        $activationTokenEntity = new ActivationTokenEntity();
        $activationTokenEntity->setToken($activationToken->encode());

        // Updating a token in the table of all activation tokens
        $activationTokenRepository->update([
            'token' => $activationTokenEntity->getToken()
        ], [
            'user_id' => $userEntity->getId()
        ]);

        return $activationTokenEntity;

    }

}