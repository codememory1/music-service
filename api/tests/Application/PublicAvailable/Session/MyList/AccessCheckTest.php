<?php

namespace App\Tests\Application\PublicAvailable\Session\MyList;

use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseTestTrait;

final class AccessCheckTest extends AbstractApiTestCase
{
    use BaseTestTrait;
    public const API_PATH = '/api/ru/public/user/session/all';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
    }

    public function testAuthorizeIsRequired(): void
    {
        $this->baseTestAuthorizeIsRequired();
    }
}