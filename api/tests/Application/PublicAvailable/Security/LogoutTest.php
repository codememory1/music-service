<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use Symfony\Component\BrowserKit\Cookie;

final class LogoutTest extends AbstractApiTestCase
{
    public function testRefreshTokenIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/logout', 'GET');

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@refreshTokenIsRequired');
    }

    public function testFailedLogout(): void
    {
        $this->createRequest('/api/ru/public/user/logout', 'GET', cookies: [
            new Cookie('refresh_token', 'InvalidRefreshToken', path: '/')
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::FAILED);
        $this->assertApiMessage('logout@failedToLogout');
    }

    public function testSuccessLogout(): UserSession
    {
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/logout', 'GET', cookies: [
            new Cookie('refresh_token', $authorizedUser->getRefreshToken(), path: '/')
        ]);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DELETE);
        $this->assertApiMessage('Вы успешно вышли из аккаунта');

        return $authorizedUser;
    }

    /**
     * @depends testSuccessLogout
     */
    public function testSuccessDeleteSession(UserSession $userSession): void
    {
        $userSessionRepository = $this->em()->getRepository(UserSession::class);

        $this->assertNull($userSessionRepository->findByRefreshToken($userSession->getRefreshToken()));
    }
}