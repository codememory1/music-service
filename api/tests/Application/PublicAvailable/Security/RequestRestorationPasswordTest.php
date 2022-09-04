<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Entity\User;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

final class RequestRestorationPasswordTest extends AbstractApiTestCase
{
    public const API_PATH = '/api/ru/public/user/password-reset/request-restoration';

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

    public function testSuccessRequestRestoration(): void
    {
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::SUCCESS_SEND);
        $this->assertApiMessage('На вашу почту отправлено сообщение для восстановление пароля');
    }

    /**
     * @depends testSuccessRequestRestoration
     */
    public function testSuccessCreateCode(): void
    {
        $email = 'developer@gmail.com';
        $userRepository = $this->em()->getRepository(User::class);

        $this->browser->addRequestData('email', $email);
        $this->browser->sendRequest();

        $this->assertNotTrue($userRepository->findByEmail($email)->getPasswordResets()->isEmpty());
    }
}