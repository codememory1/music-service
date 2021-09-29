<?php

namespace App\Services\Auth;

use App\Orm\Entities\UserEntity;
use App\Orm\Repositories\UserRepository;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\Services\AbstractService;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\HttpFoundation\Interfaces\RequestInterface;
use ReflectionException;

/**
 * Class IdentificationService
 *
 * @package App\Services\Auth
 *
 * @author  Danil
 */
class IdentificationService extends AbstractService
{

    /**
     * @param UserRepository $userRepository
     *
     * @return bool|UserEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    final public function identify(UserRepository $userRepository): bool|UserEntity
    {

        /** @var RequestInterface $request */
        $request = $this->get('request');
        $inputUsernameOrEmail = $request->post()->get('username');

        // Checking the existence of a user by the input email or username
        return $userRepository->findOneByOr([
            'email'    => $inputUsernameOrEmail,
            'username' => $inputUsernameOrEmail,
        ]);

    }

    /**
     * @param ResponseApiCollectorService $apiResponse
     * @param TranslationInterface        $translation
     *
     * @return ResponseApiCollectorService
     */
    public function getResponse(ResponseApiCollectorService $apiResponse, TranslationInterface $translation): ResponseApiCollectorService
    {

        return $apiResponse->create(400, [
            $translation->getTranslationActiveLang('auth.badIdentification')
        ]);

    }

}