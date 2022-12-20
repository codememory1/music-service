<?php

namespace App\Tests\Application\PublicAvailable\Album\Publish;

use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseTestTrait;
use Symfony\Component\HttpFoundation\Request;

final class AccessCheckTest extends AbstractApiTestCase
{
    use BaseTestTrait;
    public const API_PATH = '/api/ru/public/album/{id}/publish';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH, ['id' => 0]);
        $this->browser->setMethod(Request::METHOD_PATCH);
        $this->browser->sendRequest();
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