<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;

final class AuthorizationTest extends AbstractApiTestCase
{
    public function testEmailIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/auth', 'POST', []);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@incorrectEmail');
    }

    public function testPasswordIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/auth', 'POST', [
            'email' => 'developer@gmail.com'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@passwordIsRequired');
    }

    public function testInvalidEmail(): void
    {
        $this->createRequest('/api/ru/public/user/auth', 'POST', [
            'email' => 'invalidGmail@gmail.com',
            'password' => 'developer'
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testInvalidPassword(): void
    {
        $this->createRequest('/api/ru/public/user/auth', 'POST', [
            'email' => 'developer@gmail.com',
            'password' => 'invalidPassword'
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_CORRECTNESS);
        $this->assertApiMessage('common@incorrectPassword');
    }

    public function testSuccessAuth(): array
    {
        $this->createRequest('/api/ru/public/user/auth', 'POST', [
            'email' => 'developer@gmail.com',
            'password' => 'developer'
        ]);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::SUCCESS_AUTHORIZATION);
        $this->assertApiMessage('Вы успешно вошли в аккаунт');
        $this->assertArrayHasKey('access_token', $this->getApiResponseData());
        $this->assertArrayHasKey('refresh_token', $this->getApiResponseData());

        return $this->getApiResponseData();
    }
}