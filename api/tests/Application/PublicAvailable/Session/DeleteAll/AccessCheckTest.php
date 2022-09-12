<?php

namespace App\Tests\Application\PublicAvailable\Session\DeleteAll;

use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseTestTrait;
use Symfony\Component\HttpFoundation\Request;

final class AccessCheckTest extends AbstractApiTestCase
{
    use BaseTestTrait;
    public const API_PATH = '/api/ru/public/user/session/all/delete';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_DELETE);
    }

    public function testAuthorizeIsRequired(): void
    {
        $this->baseTestAuthorizeIsRequired();
    }
}