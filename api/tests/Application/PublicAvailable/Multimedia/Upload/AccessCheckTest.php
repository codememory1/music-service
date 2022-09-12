<?php

namespace App\Tests\Application\PublicAvailable\Multimedia\Upload;

use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseTestTrait;
use Symfony\Component\HttpFoundation\Request;

final class AccessCheckTest extends AbstractApiTestCase
{
    use BaseTestTrait;
    public const API_PATH = '/api/ru/public/user/multimedia/add';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
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