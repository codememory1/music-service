<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;

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