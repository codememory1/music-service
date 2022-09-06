<?php

namespace App\Tests\Application\PublicAvailable\Multimedia\MyList;

use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseTestTrait;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testNotEnoughPermissionsToSubscription(): void
    {
        $this->browser->setBearerAuth($this->authorize('user@gmail.com'));

        $this->baseTestNotEnoughPermissionsToSubscription();
    }
}