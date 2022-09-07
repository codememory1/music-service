<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Entity\User;
use App\Enum\ResponseTypeEnum;
use App\Service\HashingService;
use App\Tests\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

final class RestorePasswordTest extends AbstractApiTestCase
{
    public const API_PATH = '/api/ru/public/user/password-reset/restore-password';

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
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testInvalidIdentify(): void
    {
        $this->browser->addRequestData('email', 'test-user@gmail.com');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testCodeIsRequired(): void
    {
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@codeIsRequired');
    }

    public function testPasswordIsRequired(): void
    {
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->addRequestData('code', '000000');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@passwordIsRequired');
    }

    public function testPasswordMinLength(): void
    {
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->addRequestData('code', '000000');
        $this->browser->addRequestData('password', 'p');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@minPasswordLength');
    }

    public function testInvalidPasswordByRegex(): void
    {
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->addRequestData('code', '000000');
        $this->browser->addRequestData('password', 'Пароль');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@incorrectPasswordBySchema');
    }

    public function testInvalidConfirmPassword(): void
    {
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->addRequestData('code', '000000');
        $this->browser->addRequestData('password', 'new_password');
        $this->browser->addRequestData('password_confirm', 'invalid_password_confirm');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@invalidConfirmPassword');
    }

    public function testInvalidCode(): void
    {
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->addRequestData('code', '000000');
        $this->browser->addRequestData('password', 'new_password');
        $this->browser->addRequestData('password_confirm', 'new_password');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_VALID);
        $this->assertApiMessage('common@invalidCode');
    }

    public function testSuccessRestorePassword(): void
    {
        $email = 'developer@gmail.com';
        $userRepository = $this->em()->getRepository(User::class);
        $hashingService = $this->getService(HashingService::class);

        // Submit a password reset request to receive a password reset code
        $this->browser->createRequest(RequestRestorationPasswordTest::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->addRequestData('email', $email);
        $this->browser->sendRequest();

        $lastPasswordResetCode = $userRepository->findByEmail($email)->getLastPasswordResetCode();

        $this->assertNotNull($lastPasswordResetCode);

        // Reset and change password
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->addRequestData('email', $email);
        $this->browser->addRequestData('code', $lastPasswordResetCode);
        $this->browser->addRequestData('password', 'new_password');
        $this->browser->addRequestData('password_confirm', 'new_password');
        $this->browser->sendRequest();

        $this->em()->clear();

        $this->assertTrue($hashingService->compare(
            'new_password',
            $userRepository->findByEmail($email)->getPassword()
        ));
    }
}