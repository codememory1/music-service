<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

final class AuthorizationTest extends AbstractApiTestCase
{
    public const API_PATH = '/api/ru/public/user/auth';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
    }

    public function testEmailIsRequired(): void
    {
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@incorrectEmail');
    }

    public function testPasswordIsRequired(): void
    {
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@passwordIsRequired');
    }

    public function testInvalidEmail(): void
    {
        $this->browser->addRequestData('email', 'invalid-email@gmail.com');
        $this->browser->addRequestData('password', 'developer');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testInvalidPassword(): void
    {
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->addRequestData('password', 'invalidPassword');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_CORRECTNESS);
        $this->assertApiMessage('common@incorrectPassword');
    }

    public function testSuccessAuth(): void
    {
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->addRequestData('password', 'developer');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::SUCCESS_AUTHORIZATION);
        $this->assertApiMessage('Вы успешно вошли в аккаунт');
        $this->assertOnlyArrayHasKey(['access_token', 'refresh_token'], $this->browser->getResponseData());
    }
}