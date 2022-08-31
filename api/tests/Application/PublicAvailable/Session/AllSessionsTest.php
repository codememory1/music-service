<?php

namespace App\Tests\Application\PublicAvailable\Session;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\FilterableTrait;
use App\Tests\Traits\SortableTrait;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class AllSessionsTest extends AbstractApiTestCase
{
    use SortableTrait;
    use FilterableTrait;

    public function testAuthorizeIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/session/all', 'GET');

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testReturnSessions(): void
    {
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        foreach ($this->getApiResponseData() as $data) {
            $this->assertIsArray($data);
            $this->assertOnlyArrayHasKey([
                'id',
                'access_token',
                'refresh_token',
                'is_active',
                'ip',
                'browser',
                'device',
                'operating_system',
                'city',
                'country',
                'coordinates',
                'last_activity',
                'created_at',
                'updated_at'
            ], $data);
            $this->assertIsInt($data['id']);
            $this->assertIsString($data['access_token']);
            $this->assertIsString($data['refresh_token']);
            $this->assertIsBool($data['is_active']);
            $this->assertIsType(['string', 'null'], $data['ip']);
            $this->assertIsType(['string', 'null'], $data['browser']);
            $this->assertIsType(['string', 'null'], $data['device']);
            $this->assertIsType(['string', 'null'], $data['operating_system']);
            $this->assertIsType(['string', 'null'], $data['city']);
            $this->assertIsType(['string', 'null'], $data['country']);

            $this->assertIsArray($data);
            $this->assertOnlyArrayHasKey(['latitude', 'longitude'], $data['coordinates']);
            $this->assertIsType(['float', 'null'], $data['coordinates']['latitude']);
            $this->assertIsType(['float', 'null'], $data['coordinates']['longitude']);

            $this->assertDateTime($data['last_activity']);
            $this->assertDateTime($data['created_at']);
            $this->assertDateTimeWithNull($data['updated_at']);
        }
    }

    /**
     * @depends testReturnSessions
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSortAscByCreatedAt(): void
    {
        $this->authorize('developer@gmail.com');

        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all?sort[0][name]=createdAt&sort[0][value]=ASC', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $sortedData = $this->sortByAsc($this->getApiResponseData(), 'created_at');

        $this->assertSame(json_encode($this->getApiResponseData()), json_encode($sortedData));
    }

    /**
     * @depends testReturnSessions
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSortDescByCreatedAt(): void
    {
        $this->authorize('developer@gmail.com');

        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all?sort[0][name]=createdAt&sort[0][value]=DESC', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $sortedData = $this->sortByDesc($this->getApiResponseData(), 'created_at');

        $this->assertSame(json_encode($this->getApiResponseData()), json_encode($sortedData));
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSortAscByLastActivity(): void
    {
        $this->authorize('developer@gmail.com');

        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all?sort[0][name]=lastActivity&sort[0][value]=ASC', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $sortedData = $this->sortByAsc($this->getApiResponseData(), 'last_activity');

        $this->assertSame(json_encode($this->getApiResponseData()), json_encode($sortedData));
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSortDescByLastActivity(): void
    {
        $this->authorize('developer@gmail.com');

        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all?sort[0][name]=lastActivity&sort[0][value]=DESC', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $sortedData = $this->sortByDesc($this->getApiResponseData(), 'last_activity');

        $this->assertSame(json_encode($this->getApiResponseData()), json_encode($sortedData));
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSortAscByCountry(): void
    {
        $this->authorize('developer@gmail.com');

        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all?sort[0][name]=country&sort[0][value]=ASC', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $sortedData = $this->sortByAsc($this->getApiResponseData(), 'country');

        $this->assertSame(json_encode($this->getApiResponseData()), json_encode($sortedData));
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSortDescByCountry(): void
    {
        $this->authorize('developer@gmail.com');

        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all?sort[0][name]=country&sort[0][value]=DESC', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $sortedData = $this->sortByDesc($this->getApiResponseData(), 'country');

        $this->assertSame(json_encode($this->getApiResponseData()), json_encode($sortedData));
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSortAscByCity(): void
    {
        $this->authorize('developer@gmail.com');

        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all?sort[0][name]=city&sort[0][value]=ASC', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $sortedData = $this->sortByAsc($this->getApiResponseData(), 'city');

        $this->assertSame(json_encode($this->getApiResponseData()), json_encode($sortedData));
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSortDescByCity(): void
    {
        $this->authorize('developer@gmail.com');

        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all?sort[0][name]=city&sort[0][value]=DESC', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $sortedData = $this->sortByDesc($this->getApiResponseData(), 'city');

        $this->assertSame(json_encode($this->getApiResponseData()), json_encode($sortedData));
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testFilterByActive(): void
    {
        $this->authorize('developer@gmail.com', false);

        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all?filter[0][name]=isActive&filter[0][value]=true', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $filteredData = $this->filter($this->getApiResponseData(), 'is_active', true);

        $this->assertSame(json_encode($this->getApiResponseData()), json_encode($filteredData));
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testFilterByNotActive(): void
    {
        $this->authorize('developer@gmail.com', true);

        $authorizedUser = $this->authorize('developer@gmail.com', false);

        $this->createRequest('/api/ru/public/user/session/all?filter[0][name]=isActive&filter[0][value]=false', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $filteredData = $this->filter($this->getApiResponseData(), 'is_active', false);

        $this->assertSame(json_encode($this->getApiResponseData()), json_encode($filteredData));
    }
}