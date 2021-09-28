<?php

namespace App\Services\Registration;

use App\Events\UserRegisterEventEvent;
use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UsersRepository;
use App\Services\ResponseApiCollectorService;
use App\Services\Tokens\ActivationTokenService;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\Event\Exceptions\EventExistException;
use Codememory\Components\Event\Exceptions\EventNotExistException;
use Codememory\Components\Event\Exceptions\EventNotImplementInterfaceException;
use Codememory\Components\Profiling\Exceptions\BuilderNotCurrentSectionException;
use Codememory\Components\Services\AbstractService;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use ReflectionException;

/**
 * Class RefresherActivationTokenService
 *
 * @package App\Services\Registration
 *
 * @author  Danil
 */
class RefresherActivationTokenService extends AbstractService
{

    /**
     * @param UsersRepository $usersRepository
     * @param UserEntity      $userEntity
     *
     * @return RefresherActivationTokenService
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws EventExistException
     * @throws EventNotExistException
     * @throws EventNotImplementInterfaceException
     * @throws BuilderNotCurrentSectionException
     * @throws ReflectionException
     */
    final public function refresh(UsersRepository $usersRepository, UserEntity $userEntity): RefresherActivationTokenService
    {

        /** @var ActivationTokenService $activationTokenService */
        $activationToken = $this->get('activation-token');
        $tokenForActivation = $activationToken->encode();

        $userEntity->setActivationToken($tokenForActivation);

        $usersRepository->update([
            'activation_token' => $userEntity->getActivationToken()
        ], $userEntity->getEmail());

        // Raising the user registration event
        $this->dispatchEvent(UserRegisterEventEvent::class, [
            $this->get('mailer'),
            $userEntity
        ]);

        return $this;

    }

    /**
     * @return ResponseApiCollectorService
     */
    final public function getResponse(): ResponseApiCollectorService
    {

        /** @var ResponseApiCollectorService $apiResponse */
        $apiResponse = $this->get('api-response');

        /** @var TranslationInterface $translation */
        $translation = $this->get('translator');

        return $apiResponse->create(200, [
            $translation->getTranslationActiveLang('register.successRegister')
        ]);

    }

}