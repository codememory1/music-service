<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Entity\User;
use App\Enum\ResponseTypeEnum;
use App\Service\HashingService;
use App\Tests\AbstractApiTestCase;

final class RestorePasswordTest extends AbstractApiTestCase
{
    public function testEmailIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/password-reset/restore-password', 'POST');

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testInvalidIdentify(): void
    {
        $this->createRequest('/api/ru/public/user/password-reset/restore-password', 'POST', [
            'email' => 'test-user@gmail.com'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testCodeIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/password-reset/restore-password', 'POST', [
            'email' => 'developer@gmail.com'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@codeIsRequired');
    }

    public function testPasswordIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/password-reset/restore-password', 'POST', [
            'email' => 'developer@gmail.com',
            'code' => '000000'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@passwordIsRequired');
    }

    public function testPasswordMinLength(): void
    {
        $this->createRequest('/api/ru/public/user/password-reset/restore-password', 'POST', [
            'email' => 'developer@gmail.com',
            'code' => '000000',
            'password' => 'p'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@minPasswordLength');
    }

    public function testInvalidPasswordByRegex(): void
    {
        $this->createRequest('/api/ru/public/user/password-reset/restore-password', 'POST', [
            'email' => 'developer@gmail.com',
            'code' => '000000',
            'password' => 'Пароль'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@incorrectPasswordBySchema');
    }

    public function testInvalidConfirmPassword(): void
    {
        $this->createRequest('/api/ru/public/user/password-reset/restore-password', 'POST', [
            'email' => 'developer@gmail.com',
            'code' => '000000',
            'password' => 'new_password',
            'confirm_password' => 'invalid_confirm_password'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@invalidConfirmPassword');
    }

    public function testInvalidCode(): void
    {
        $this->createRequest('/api/ru/public/user/password-reset/restore-password', 'POST', [
            'email' => 'developer@gmail.com',
            'code' => '000000',
            'password' => 'new_password',
            'password_confirm' => 'new_password'
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_VALID);
        $this->assertApiMessage('common@invalidCode');
    }

    public function testSuccessRestorePassword(): void
    {
        $email = 'developer@gmail.com';
        $userRepository = $this->em()->getRepository(User::class);
        $hashingService = $this->getService(HashingService::class);

        $this->createRequest('/api/ru/public/user/password-reset/request-restoration', 'POST', [
            'email' => $email
        ]);

        $lastPasswordReset = $userRepository->findByEmail($email)->getPasswordResets()->last();

        $this->assertNotFalse($lastPasswordReset);

        $this->createRequest('/api/ru/public/user/password-reset/restore-password', 'POST', [
            'email' => $email,
            'code' => $lastPasswordReset->getCode(),
            'password' => 'new_password',
            'password_confirm' => 'new_password'
        ]);

        $this->em()->clear();

        $this->assertTrue($hashingService->compare(
            'new_password',
            $userRepository->findByEmail($email)->getPassword()
        ));
    }
}