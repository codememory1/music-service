<?php

namespace App\Tests\Application\PublicAvailable\Album\MyList;

use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseTestTrait;

final class AccessCheckTest extends AbstractApiTestCase
{
    use BaseTestTrait;
    public const API_PATH = '/api/ru/public/album/all';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
    }

    public function testAuthorizationIsRequired(): void
    {
        $this->baseTestAuthorizeIsRequired();
    }
}