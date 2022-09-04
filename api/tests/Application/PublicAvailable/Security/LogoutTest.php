<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class LogoutTest extends AbstractApiTestCase
{
    public const API_PATH = '/api/ru/public/user/logout';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
    }

    public function testRefreshTokenIsRequired(): void
    {
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@refreshTokenIsRequired');
    }

    public function testFailedLogout(): void
    {
        $this->browser->addCookie('refresh_token', 'InvalidRefreshToken');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::FAILED);
        $this->assertApiMessage('logout@failedToLogout');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSuccessLogout(): void
    {
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addCookie('refresh_token', $authorizedUserSession->getRefreshToken());
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DELETE);
        $this->assertApiMessage('Вы успешно вышли из аккаунта');
    }

    /**
     * @depends testSuccessLogout
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSuccessDeleteSession(): void
    {
        $userSessionRepository = $this->em()->getRepository(UserSession::class);
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addCookie('refresh_token', $authorizedUserSession->getRefreshToken());
        $this->browser->sendRequest();

        $this->assertNull($userSessionRepository->findByRefreshToken($authorizedUserSession->getRefreshToken()));
    }
}