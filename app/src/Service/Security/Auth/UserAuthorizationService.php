<?php

namespace App\Service\Security\Auth;

use App\DTO\AuthorizationDTO;
use App\Entity\User;
use App\Enum\ApiResponseTypeEnum;
use App\Enum\StatusEnum;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserAuthorizationService
 *
 * @package App\Service\Security\Auth
 *
 * @author  Codememory
 */
class UserAuthorizationService extends AbstractApiService
{

    /**
     * @param AuthorizationDTO   $authorizationDTO
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function authorize(AuthorizationDTO $authorizationDTO, ValidatorInterface $validator): ApiResponseService
    {

        /** @var UserIdentificationService $userIdentifyService */
        $userIdentifyService = $this->getCollectedService(UserIdentificationService::class);

        /** @var UserAuthenticationService $userAuthenticationService */
        $userAuthenticationService = $this->getCollectedService(UserAuthenticationService::class);

        // Validation of input POST data
        if (true !== $resultInputValidation = $this->inputValidation($authorizationDTO, $validator)) {
            return $resultInputValidation;
        }

        // Check identify user
        $identifiedUser = $userIdentifyService->identify($authorizationDTO);

        if ($identifiedUser instanceof ApiResponseService) {
            return $identifiedUser;
        }

        // Check status
        if (true !== $resultCheckActive = $this->checkActivity($identifiedUser)) {
            return $resultCheckActive;
        }

        // Check authentication user
        $authenticationUser = $userAuthenticationService->authenticate($identifiedUser, $authorizationDTO);

        if ($authenticationUser instanceof ApiResponseService) {
            return $authenticationUser;
        }

        // Create user session
        $createdUserSession = $this->createSession($identifiedUser, $authorizationDTO);

        return $this->getSuccessResponse($createdUserSession);

    }

    /**
     * @param User $identityUser
     *
     * @return ApiResponseService|bool
     * @throws Exception
     */
    private function checkActivity(User $identityUser): ApiResponseService|bool
    {

        if ($identityUser->getStatus() !== StatusEnum::ACTIVE->value) {
            $this
                ->prepareApiResponse('error', 400)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_ACTIVE,
                    'account_not_active',
                    $this->getTranslation('user@accountNotActive')
                );

            return $this->getPreparedApiResponse();
        }

        return true;

    }

    /**
     * @param User             $identifiedUser
     * @param AuthorizationDTO $authorizationDTO
     *
     * @return CreatorUserSessionService
     */
    private function createSession(User $identifiedUser, AuthorizationDTO $authorizationDTO): CreatorUserSessionService
    {

        /** @var CreatorUserSessionService $userSessionService */
        $userSessionService = $this->getCollectedService(CreatorUserSessionService::class);

        $userSessionService->create($identifiedUser, $authorizationDTO);

        return $userSessionService;

    }

    /**
     * @param CreatorUserSessionService $createdUserSession
     *
     * @return ApiResponseService
     * @throws Exception
     */
    private function getSuccessResponse(CreatorUserSessionService $createdUserSession): ApiResponseService
    {

        $this
            ->prepareApiResponse('success', 200)
            ->setMessage(
                ApiResponseTypeEnum::AUTH,
                'success_auth',
                $this->getTranslation('user@successAuth')
            )
            ->setData([
                'access_token'  => $createdUserSession->getAccessToken(),
                'refresh_token' => $createdUserSession->getRefreshToken()
            ]);

        return $this->getPreparedApiResponse();

    }

}