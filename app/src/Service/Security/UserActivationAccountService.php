<?php

namespace App\Service\Security;

use App\Entity\UserActivationToken;
use App\Enums\ApiResponseTypeEnum;
use App\Enums\StatusEnum;
use App\Repository\UserActivationTokenRepository;
use App\Service\AbstractApiService;
use App\Service\ParseCronTimeService;
use App\Service\Response\ApiResponseService;
use DateTimeImmutable;
use Exception;

/**
 * Class UserActivationAccountService
 *
 * @package App\Service\Security
 *
 * @author  Codememory
 */
class UserActivationAccountService extends AbstractApiService
{

    /**
     * @param string $hash
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function activate(string $hash): ApiResponseService
    {

        /** @var UserActivationTokenRepository $userActivationTokenRepository */
        $userActivationTokenRepository = $this->em->getRepository(UserActivationToken::class);

        // Check exist token
        if (null === $finedToken = $userActivationTokenRepository->findOneBy(['token' => $hash])) {
            $this->prepareApiResponse('error', 404)
                 ->setMessage(
                     ApiResponseTypeEnum::CHECK_EXIST,
                     'token_not_exist',
                     $this->getTranslation('userActivationAccount@tokenNotExist')
                 );

            return $this->getPreparedApiResponse();
        }

        // Check is valid token
        if (false !== $resultIsValid = $this->isValid($finedToken)) {
            return $resultIsValid;
        }

        // Change user status
        $this->setHandler(function(UserActivationToken $userActivationTokenEntity) use ($finedToken) {
            $userActivationTokenEntity->getUser()->setStatus(StatusEnum::ACTIVE->value);

            $this->em->flush();
        });

        return $this->remove($finedToken, 'userActivationAccount@successActivation');

    }

    /**
     * @param UserActivationToken $userActivationToken
     *
     * @return ApiResponseService|bool
     * @throws Exception
     */
    private function isValid(UserActivationToken $userActivationToken): ApiResponseService|bool
    {

        $parseCronTime = new ParseCronTimeService();

        $validInSecond = $parseCronTime
            ->setTime($userActivationToken->getValid())
            ->toSecond();
        $valid = $userActivationToken->getCreatedAt()->getTimestamp() + $validInSecond;

        // Check valid token
        if ((new DateTimeImmutable())->getTimestamp() >= $valid) {
            $this->prepareApiResponse('error', 404)
                 ->setMessage(
                     ApiResponseTypeEnum::IS_VALID,
                     'token_is_not_valid',
                     $this->getTranslation('userActivationAccount@tokenIsNotValid')
                 );

            return $this->getPreparedApiResponse();
        }

        return false;

    }

}