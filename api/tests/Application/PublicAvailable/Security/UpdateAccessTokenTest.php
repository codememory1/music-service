<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

final class UpdateAccessTokenTest extends AbstractApiTestCase
{
    public const API_PATH = '/api/ru/public/user/access-token/update';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_PUT);
    }

    public function testRefreshTokenIsRequired(): void
    {
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@refreshTokenIsRequired');
    }

    public function testInvalidRefreshToken(): void
    {
        $this->browser->addCookie('refresh_token', 'InvalidRefreshToken');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::FAILED);
        $this->assertApiMessage('common@failedToUpdateAccessToken');
    }

    public function testSuccessUpdate(): void
    {
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addCookie('refresh_token', $authorizedUserSession->getRefreshToken());
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::UPDATE);
        $this->assertApiMessage('Токен успешно обновлен');
        $this->assertOnlyArrayHasKey(['access_token', 'refresh_token'], $this->browser->getResponseData());
        $this->assertNotEquals($this->browser->getResponseData('access_token'), $authorizedUserSession->getAccessToken());
        $this->assertNotEquals($this->browser->getResponseData('refresh_token'), $authorizedUserSession->getRefreshToken());
    }
}