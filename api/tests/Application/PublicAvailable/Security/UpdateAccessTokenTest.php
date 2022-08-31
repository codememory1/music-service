<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class UpdateAccessTokenTest extends AbstractApiTestCase
{
    public function testRefreshTokenIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/access-token/update', 'PUT');

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@refreshTokenIsRequired');
    }

    public function testInvalidRefreshToken(): void
    {
        $this->createRequest('/api/ru/public/user/access-token/update', 'PUT', cookies: [
            new Cookie('refresh_token', 'InvalidRefreshToken', path: '/')
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::FAILED);
        $this->assertApiMessage('common@failedToUpdateAccessToken');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSuccessUpdate(): void
    {
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/access-token/update', 'PUT', cookies: [
            new Cookie('refresh_token', $authorizedUser->getRefreshToken(), path: '/')
        ]);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::UPDATE);
        $this->assertApiMessage('Токен успешно обновлен');
        $this->assertArrayHasKey('access_token', $this->getApiResponseData());
        $this->assertArrayHasKey('refresh_token', $this->getApiResponseData());
        $this->assertNotEquals($this->getApiResponseData()['access_token'], $authorizedUser->getAccessToken());
        $this->assertNotEquals($this->getApiResponseData()['refresh_token'], $authorizedUser->getRefreshToken());
    }
}