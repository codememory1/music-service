<?php

namespace App\Service\Security\Auth;

use App\Entity\User;
use App\Enums\ApiResponseTypeEnum;
use App\Enums\StatusEnum;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
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
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function authorize(ValidatorInterface $validator): ApiResponseService
    {

        $userIdentifyService = new UserIdentificationService($this->request, $this->response, $this->managerRegistry);
        $userAuthenticationService = new UserAuthenticationService($this->request, $this->response, $this->managerRegistry);
        $inputValidationService = new InputValidationService($this->request, $this->response, $this->managerRegistry);

        $login = $this->request->get('login', '');
        $password = $this->request->get('password', '');

        // Input POST validation
        if (true !== $resultInputValidation = $inputValidationService->validate($validator)) {
            return $resultInputValidation;
        }

        // Check identify user
        $identifiedUser = $userIdentifyService->identify($login);

        if ($identifiedUser instanceof ApiResponseService) {
            return $identifiedUser;
        }

        // Check status
        if (true !== $resultCheckActive = $this->checkActivity($identifiedUser)) {
            return $resultCheckActive;
        }

        // Check authentication user
        $authenticationUser = $userAuthenticationService->authenticate($identifiedUser, $password);

        if ($authenticationUser instanceof ApiResponseService) {
            return $authenticationUser;
        }

        // Create user session
        $createdUserSession = $this->createSession($identifiedUser);

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
            $this->prepareApiResponse('error', 400)
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
     * @param User $identifiedUser
     *
     * @return CreatorUserSessionService
     */
    private function createSession(User $identifiedUser): CreatorUserSessionService
    {

        $userSessionService = new CreatorUserSessionService($this->request, $this->response, $this->managerRegistry);

        $userSessionService->create($identifiedUser);

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

        $this->prepareApiResponse('success', 200)
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