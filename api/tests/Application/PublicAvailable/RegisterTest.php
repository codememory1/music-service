<?php

namespace App\Tests\Application\PublicAvailable;

use App\Entity\AccountActivationCode;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\SecurityTrait;

final class RegisterTest extends AbstractApiTestCase
{
    use SecurityTrait;

    public function testPseudonymIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/register', 'POST');

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('userProfile@pseudonymIsRequired');
    }

    public function testEmailIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/register', 'POST', [
            'pseudonym' => 'Codememory'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@incorrectEmail');
    }

    public function testInvalidEmail(): void
    {
        $this->createRequest('/api/ru/public/user/register', 'POST', [
            'pseudonym' => 'Codememory',
            'email' => 'invalid-email'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@incorrectEmail');
    }

    public function testPasswordIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/register', 'POST', [
            'pseudonym' => 'Codememory',
            'email' => 'test-user@gmail.com'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@passwordIsRequired');
    }

    public function testInvalidPassword(): void
    {
        $this->createRequest('/api/ru/public/user/register', 'POST', [
            'pseudonym' => 'Codememory',
            'email' => 'test-user@gmail.com',
            'password' => '0000'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@minPasswordLength');
    }

    public function testInvalidConfirmPassword(): void
    {
        $this->createRequest('/api/ru/public/user/register', 'POST', [
            'pseudonym' => 'Codememory',
            'email' => 'test-user@gmail.com',
            'password' => 'test_user_password',
            'password_confirm' => 'test_user_password_confirm'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@invalidConfirmPassword');
    }

    public function testEmailExist(): void
    {
        $this->createRequest('/api/ru/public/user/register', 'POST', [
            'pseudonym' => 'Codememory',
            'email' => 'developer@gmail.com',
            'password' => 'test_user_password',
            'password_confirm' => 'test_user_password'
        ]);

        $this->assertApiStatusCode(409);
        $this->assertApiType(ResponseTypeEnum::EXIST);
        $this->assertApiMessage('user@existByEmail');
    }

    public function testSuccessRegister(): void
    {
        $this->register();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::SUCCESS_REGISTRATION);
        $this->assertApiMessage('Регистрация прошла успешно! На почту отправлена ссылка для активации аккаунта');
    }

    /**
     * @depends testSuccessRegister
     */
    public function testSuccessCreateUser(): void
    {
        $userRepository = $this->em()->getRepository(User::class);

        $this->assertNotNull($userRepository->findByEmail($this->register()));
    }

    /**
     * @depends testSuccessCreateUser
     */
    public function testSuccessCreateRegisteredUserSession(): void
    {
        $userSessionRepository = $this->em()->getRepository(UserSession::class);
        $userRepository = $this->em()->getRepository(User::class);
        $registeredUser = $userRepository->findByEmail($this->register());

        $this->assertNotNull($userSessionRepository->findRegistered($registeredUser));
    }

    /**
     * @depends testSuccessCreateUser
     */
    public function testSuccessCreateAccountActivationCode(): void
    {
        $accountActivationCodeRepository = $this->em()->getRepository(AccountActivationCode::class);
        $userRepository = $this->em()->getRepository(User::class);
        $registeredUser = $userRepository->findByEmail($this->register());

        $this->assertNotEmpty($accountActivationCodeRepository->findAllByUser($registeredUser));
    }
}