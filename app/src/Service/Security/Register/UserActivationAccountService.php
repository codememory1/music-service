<?php

namespace App\Service\Security\Register;

use App\Entity\UserActivationToken;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Repository\UserActivationTokenRepository;
use App\Service\AbstractApiService;
use App\Service\ParseCronTimeService;
use App\Service\Response\ApiResponseService;
use DateTimeImmutable;
use Exception;

/**
 * Class UserActivationAccountService
 *
 * @package App\Service\Security\Register
 *
 * @author  Codememory
 */
class UserActivationAccountService extends AbstractApiService
{

    /**
     * @param string $token
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function activate(string $token): ApiResponseService
    {

        /** @var UserActivationTokenRepository $userActivationTokenRepository */
        $userActivationTokenRepository = $this->em->getRepository(UserActivationToken::class);
        $finedToken = $this->existToken($userActivationTokenRepository, $token);

        // Check exist token
        if ($finedToken instanceof ApiResponseService) {
            return $finedToken;
        }

        // Check is valid token
        if (false !== $resultIsValid = $this->isValid($finedToken)) {
            return $resultIsValid;
        }

        // Change user status
        $this->changeUserStatus($finedToken, StatusEnum::ACTIVE);

        return $this->remove($finedToken, 'userActivationAccount@successActivation');

    }

    /**
     * @param UserActivationTokenRepository $userActivationTokenRepository
     * @param string                        $token
     *
     * @return UserActivationToken|ApiResponseService
     * @throws Exception
     */
    private function existToken(UserActivationTokenRepository $userActivationTokenRepository, string $token): UserActivationToken|ApiResponseService
    {

        if (null === $finedToken = $userActivationTokenRepository->findOneBy(['token' => $token])) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'token_not_exist',
                    $this->getTranslation('userActivationAccount@tokenNotExist')
                );

            return $this->getPreparedApiResponse();
        }

        return $finedToken;

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

        $createdAt = $userActivationToken->getCreatedAt()->getTimestamp();
        $updatedAt = $userActivationToken->getUpdatedAt()?->getTimestamp();
        $createdOrUpdated = $updatedAt ?? $createdAt;

        $validInSecond = $parseCronTime
            ->setTime($userActivationToken->getValid())
            ->toSecond();

        // Check valid token
        if ((new DateTimeImmutable())->getTimestamp() >= $createdOrUpdated + $validInSecond) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::IS_VALID,
                    'token_is_not_valid',
                    $this->getTranslation('userActivationAccount@tokenIsNotValid')
                );

            return $this->getPreparedApiResponse();
        }

        return false;

    }

    /**
     * @param UserActivationToken $userActivationToken
     * @param StatusEnum          $statusEnum
     *
     * @return void
     */
    private function changeUserStatus(UserActivationToken $userActivationToken, StatusEnum $statusEnum): void
    {

        $userActivationToken
            ->getUser()
            ->setStatus($statusEnum->value);

        $this->em->flush();

    }

}