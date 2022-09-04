<?php

namespace App\Tests\Application\PublicAvailable\Security;

use App\Entity\User;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\SecurityTrait;
use Symfony\Component\HttpFoundation\Request;

final class ActivationAccountTest extends AbstractApiTestCase
{
    use SecurityTrait;
    public const API_PATH = '/api/ru/public/user/account-activation';

    public function testEmailIsRequired(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testInvalidIdentify(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->addRequestData('email', 'invalid-email@gmail.com');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testCodeIsRequired(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->addRequestData('email', 'developer@gmail.com');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@invalidCode');
    }

    public function testInvalidCode(): void
    {
        $registeredEmail = $this->register();

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->addRequestData('email', $registeredEmail);
        $this->browser->addRequestData('code', '000000');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_VALID);
        $this->assertApiMessage('common@invalidCode');
    }

    public function testSuccessActivate(): void
    {
        $registeredEmail = $this->register();
        $userRepository = $this->em()->getRepository(User::class);
        $user = $userRepository->findByEmail($registeredEmail);

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->addRequestData('email', $registeredEmail);
        $this->browser->addRequestData('code', $user->getLastAccountActivationCode());
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::UPDATE);
        $this->assertApiMessage('Аккаунт успешно активирован');

        $this->em()->clear();

        $this->assertTrue($userRepository->findByEmail($registeredEmail)->isActive());
    }
}