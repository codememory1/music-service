<?php

namespace App\Tests\Application\PublicAvailable;

use App\Entity\User;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\SecurityTrait;

final class ActivationAccountTest extends AbstractApiTestCase
{
    use SecurityTrait;

    public function testEmailIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/account-activation', 'POST');

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testInvalidIdentify(): void
    {
        $this->createRequest('/api/ru/public/user/account-activation', 'POST', [
            'email' => 'invalid-email@gmail.com'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testCodeIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/account-activation', 'POST', [
            'email' => 'developer@gmail.com'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@invalidCode');
    }

    public function testInvalidCode(): void
    {
        $registeredEmail = $this->register();

        $this->createRequest('/api/ru/public/user/account-activation', 'POST', [
            'email' => $registeredEmail,
            'code' => 000000
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_VALID);
        $this->assertApiMessage('common@invalidCode');
    }

    public function testSuccessActivate(): void
    {
        $userRepository = $this->em()->getRepository(User::class);
        $registeredEmail = $this->register();
        $user = $userRepository->findByEmail($registeredEmail);

        $this->createRequest('/api/ru/public/user/account-activation', 'POST', [
            'email' => $registeredEmail,
            'code' => $user->getAccountActivationCode()->last()->getCode()
        ]);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::UPDATE);
        $this->assertApiMessage('Аккаунт успешно активирован');
        $this->assertTrue($user->isActive());
    }
}