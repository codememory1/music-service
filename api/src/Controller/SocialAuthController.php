<?php

namespace App\Controller;

use App\DTO\SocialAuthDTO;
use App\Rest\ApiController;
use App\Rest\Http\Response;
use App\Rest\Http\ResponseCollection;
use App\Security\Auth\Authorization;
use App\Security\Authenticator\DefineUserForTask;
use App\Security\SocialAuth\AbstractSocialAuth;
use App\Security\SocialAuth\GoogleAuth;
use App\Security\SocialAuth\YandexAuth;
use App\Service\Google\GoogleOAuthClient;
use App\Service\Yandex\YandexOAuthClient;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SocialAuthController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/auth')]
class SocialAuthController extends ApiController
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @var SocialAuthDTO
     */
    private SocialAuthDTO $socialAuthDTO;

    /**
     * @var Authorization
     */
    private Authorization $authorization;

    #[Pure]
    public function __construct(
        EntityManagerInterface $managerRegistry,
        ResponseCollection $responseCollection,
        DefineUserForTask $defineUserForTask,
        EventDispatcherInterface $eventDispatcher,
        SocialAuthDTO $socialAuthDTO,
        Authorization $authorization
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->socialAuthDTO = $socialAuthDTO;
        $this->authorization = $authorization;

        parent::__construct($managerRegistry, $responseCollection, $defineUserForTask);
    }

    /**
     * @param GoogleOAuthClient $googleOAuthClient
     *
     * @return JsonResponse
     */
    #[Route('/google/url', methods: 'GET')]
    public function googleAuthLink(GoogleOAuthClient $googleOAuthClient): JsonResponse
    {
        return $this->responseCollection->dataOutput([
            'url' => $googleOAuthClient->getUrlGenerator()->generateAuthUrl()
        ])->getResponse()->make();
    }

    /**
     * @param GoogleAuth $googleAuth
     *
     * @return JsonResponse
     */
    #[Route('/google', methods: 'POST')]
    public function googleAuth(GoogleAuth $googleAuth): JsonResponse
    {
        return $this->auth($googleAuth);
    }

    /**
     * @param YandexOAuthClient $yandexOAuthClient
     *
     * @return JsonResponse
     */
    #[Route('/yandex/url', methods: 'GET')]
    public function yandexAuthLink(YandexOAuthClient $yandexOAuthClient): JsonResponse
    {
        return $this->responseCollection->dataOutput([
            'url' => $yandexOAuthClient->getUrlGenerator()->generateAuthUrl()
        ])->getResponse()->make();
    }

    /**
     * @param YandexAuth $yandexAuth
     *
     * @return JsonResponse
     */
    #[Route('/yandex', methods: 'POST')]
    public function yandexAuth(YandexAuth $yandexAuth): JsonResponse
    {
        return $this->auth($yandexAuth);
    }

    /**
     * @param SocialAuthDTO            $socialAuthDTO
     * @param AbstractSocialAuth       $socialAuth
     * @param Authorization            $authorization
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return JsonResponse
     */
    private function auth(AbstractSocialAuth $socialAuth): JsonResponse
    {
        $authorizationToken = $socialAuth->make(
            $this->eventDispatcher,
            $this->socialAuthDTO->code
        );

        if ($authorizationToken instanceof Response) {
            return $authorizationToken->make();
        }

        return $this->authorization->successAuthResponse([
            'access_token' => $authorizationToken->getAccessToken(),
            'refresh_token' => $authorizationToken->getRefreshToken()
        ])->make();
    }
}