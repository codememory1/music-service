<?php

namespace App\Tests\Application\PublicAvailable\Multimedia\MyList;

use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseTestTrait;

final class AccessCheckTest extends AbstractApiTestCase
{
    use BaseTestTrait;
    public const API_PATCH = '/api/ru/public/user/multimedia/all';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATCH);
    }

    public function testAuthorizationIsRequired(): void
    {
        $this->baseTestAuthorizeIsRequired();
    }

    public function testNotEnoughPermissionsToSubscription(): void
    {
        $this->browser->setBearerAuth($this->authorize('user@gmail.com'));

        $this->baseTestNotEnoughPermissionsToSubscription();
    }
}