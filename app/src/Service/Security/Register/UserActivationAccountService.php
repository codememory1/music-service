<?php

namespace App\Service\Security\Register;

use App\Entity\UserActivationToken;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Repository\UserActivationTokenRepository;
use App\Rest\ApiService;
use App\Rest\Http\Response;
use App\Service\ParseCronTimeService;
use DateTimeImmutable;
use Exception;

/**
 * Class UserActivationAccountService.
 *
 * @package App\Service\Security\Register
 *
 * @author  Codememory
 */
class UserActivationAccountService extends ApiService
{
    /**
     * @param string $token
     *
     * @throws Exception
     *
     * @return Response
     */
    public function activate(string $token): Response
    {
        /** @var UserActivationTokenRepository $userActivationTokenRepository */
        $userActivationTokenRepository = $this->em->getRepository(UserActivationToken::class);
        $finedToken = $this->existToken($userActivationTokenRepository, $token);

        // Check exist token
        if ($finedToken instanceof Response) {
            return $finedToken;
        }

        // Check is valid token
        if (false !== $resultIsValid = $this->isValid($finedToken)) {
            return $resultIsValid;
        }

        // Change user status
        $this->changeUserStatus($finedToken, StatusEnum::ACTIVE);

        return $this->manager->remove($finedToken, 'userActivationAccount@successActivation');
    }

    /**
     * @param UserActivationTokenRepository $userActivationTokenRepository
     * @param string                        $token
     *
     * @throws Exception
     *
     * @return Response|UserActivationToken
     */
    private function existToken(UserActivationTokenRepository $userActivationTokenRepository, string $token): UserActivationToken|Response
    {
        if (null === $finedToken = $userActivationTokenRepository->findOneBy(['token' => $token])) {
            $this->apiResponseSchema->setMessage(
                ApiResponseTypeEnum::CHECK_EXIST,
                $this->getTranslation('userActivationAccount@tokenNotExist')
            );

            return new Response($this->apiResponseSchema, 'error', 404);
        }

        return $finedToken;
    }

    /**
     * @param UserActivationToken $userActivationToken
     *
     * @throws Exception
     *
     * @return bool|Response
     */
    private function isValid(UserActivationToken $userActivationToken): Response|bool
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
            $this->apiResponseSchema->setMessage(
                ApiResponseTypeEnum::CHECK_VALID,
                $this->getTranslation('userActivationAccount@tokenIsNotValid')
            );

            return new Response($this->apiResponseSchema, 'error', 400);
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