<?php

namespace App\Tests\Application\PublicAvailable\Session\Delete;

use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseTestTrait;
use Symfony\Component\HttpFoundation\Request;

final class AccessCheckTest extends AbstractApiTestCase
{
    use BaseTestTrait;
    public const API_PATH = '/api/ru/public/user/session/{id}/delete';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_DELETE);
    }

    public function testAuthorizeIsRequired(): void
    {
        $this->browser->addParameter('id', 0);

        $this->baseTestAuthorizeIsRequired();
    }
}