<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Service\HashingService;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\SecurityTrait;
use Symfony\Component\HttpFoundation\Request;

final class RegisterTest extends AbstractApiTestCase
{
    use SecurityTrait;
    public const API_PATH = '/api/ru/public/user/register';
    private array $validData = [
        'pseudonym' => 'Codememory',
        'email' => 'test-user@gmail.com',
        'password' => 'test_user_password'
    ];

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
    }

    public function testPseudonymIsRequired(): void
    {
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('userProfile@pseudonymIsRequired');
    }

    public function testEmailIsRequired(): void
    {
        $this->browser->addRequestData('pseudonym', $this->validData['pseudonym']);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@incorrectEmail');
    }

    public function testInvalidEmail(): void
    {
        $this->browser->addRequestData('pseudonym', $this->validData['pseudonym']);
        $this->browser->addRequestData('email', 'invalid-email');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@incorrectEmail');
    }

    public function testPasswordIsRequired(): void
    {
        $this->browser->addRequestData('pseudonym', $this->validData['pseudonym']);
        $this->browser->addRequestData('email', $this->validData['email']);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@passwordIsRequired');
    }

    public function testInvalidPassword(): void
    {
        $this->browser->addRequestData('pseudonym', $this->validData['pseudonym']);
        $this->browser->addRequestData('email', $this->validData['email']);
        $this->browser->addRequestData('password', '0000');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@minPasswordLength');
    }

    public function testInvalidConfirmPassword(): void
    {
        $this->browser->addRequestData('pseudonym', $this->validData['pseudonym']);
        $this->browser->addRequestData('email', $this->validData['email']);
        $this->browser->addRequestData('password', $this->validData['password']);
        $this->browser->addRequestData('password_confirm', 'test_user_password_confirm');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@invalidConfirmPassword');
    }

    public function testEmailExist(): void
    {
        $this->browser->addRequestData('pseudonym', $this->validData['pseudonym']);
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->addRequestData('password', $this->validData['password']);
        $this->browser->addRequestData('password_confirm', $this->validData['password']);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(409);
        $this->assertApiType(ResponseTypeEnum::EXIST);
        $this->assertApiMessage('user@existByEmail');
    }

    public function testSuccessRegister(): void
    {
        $this->successRegister();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::SUCCESS_REGISTRATION);
        $this->assertApiMessage('Регистрация прошла успешно! На почту отправлена ссылка для активации аккаунта');
    }

    /**
     * @depends testSuccessRegister
     */
    public function testSuccessCreateUser(): void
    {
        $this->successRegister();

        $hashingService = $this->getService(HashingService::class);
        $userRepository = $this->em()->getRepository(User::class);
        $userSessionRepository = $this->em()->getRepository(UserSession::class);
        $registeredUser = $userRepository->findByEmail($this->validData['email']);

        $this->assertNotNull($registeredUser);
        $this->assertNotNull($registeredUser->getLastAccountActivationCode());
        $this->assertNotNull($registeredUser->getProfile());
        $this->assertNotNull($userSessionRepository->findRegistered($registeredUser));
        $this->assertEquals($this->validData['pseudonym'], $registeredUser->getProfile()->getPseudonym());
        $this->assertEquals($this->validData['email'], $registeredUser->getEmail());
        $this->assertTrue($hashingService->compare(
            $this->validData['password'],
            $registeredUser->getPassword()
        ));
    }

    private function successRegister(): void
    {
        $this->browser->addRequestData('pseudonym', $this->validData['pseudonym']);
        $this->browser->addRequestData('email', $this->validData['email']);
        $this->browser->addRequestData('password', $this->validData['password']);
        $this->browser->addRequestData('password_confirm', $this->validData['password']);
        $this->browser->sendRequest();
    }
}