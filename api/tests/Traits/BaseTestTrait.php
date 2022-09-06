<?php

namespace App\Tests\Traits;

use App\Enum\ResponseTypeEnum;

trait BaseTestTrait
{
    private function baseTestAuthorizeIsRequired(): void
    {
        $this->browser->sendRequest();

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    private function baseTestNotEnoughPermissionsToSubscription(): void
    {
        $this->browser->sendRequest();

        $this->assertApiStatusCode(403);
        $this->assertApiType(ResponseTypeEnum::CHECK_ACCESS);
        $this->assertApiMessage('accessDenied@notSubscriptionPermissions');
    }
}