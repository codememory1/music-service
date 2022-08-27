<?php

namespace App\Tests\Application\PublicAvailable;

use App\Entity\PasswordReset;
use App\Entity\User;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;

final class RequestRestorationPasswordTest extends AbstractApiTestCase
{
    public function testEmailIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/password-reset/request-restoration', 'POST');

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testInvalidIdentify(): void
    {
        $this->createRequest('/api/ru/public/user/password-reset/request-restoration', 'POST', [
            'email' => 'test-user@gmail.com'
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('user@failedToIdentify');
    }

    public function testSuccessRequestRestoration(): User
    {
        $userRepository = $this->em()->getRepository(User::class);

        $this->createRequest('/api/ru/public/user/password-reset/request-restoration', 'POST', [
            'email' => 'developer@gmail.com'
        ]);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::SUCCESS_SEND);
        $this->assertApiMessage('На вашу почту отправлено сообщение для восстановление пароля');

        return $userRepository->findByEmail('developer@gmail.com');
    }

    /**
     * @depends testSuccessRequestRestoration
     */
    public function testSuccessCreateCode(User $user): void
    {
        $passwordResetRepository = $this->em()->getRepository(PasswordReset::class);

        $this->createRequest('/api/ru/public/user/password-reset/request-restoration', 'POST', [
            'email' => 'developer@gmail.com'
        ]);

        $this->assertNotEmpty($passwordResetRepository->findAllByUser($user));
    }
}