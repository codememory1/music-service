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
    public const API_PATH = '/api/ru/public/user/session/all';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
    }

    public function testAuthorizeIsRequired(): void
    {
        $this->browser->sendRequest();

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
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        foreach ($this->browser->getResponseData() as $data) {
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
        $this->authorize('developer@gmail.com'); // Authorization and creation of the first session

        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addSortQuery('createdAt', 'ASC');
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), 'created_at');

        $this->assertSame(json_encode($this->browser->getResponseData()), json_encode($sortedData));
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
        $this->authorize('developer@gmail.com'); // Authorization and creation of the first session

        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addSortQuery('createdAt', 'DESC');
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), 'created_at');

        $this->assertSame(json_encode($this->browser->getResponseData()), json_encode($sortedData));
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
        $this->authorize('developer@gmail.com'); // Authorization and creation of the first session

        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addSortQuery('lastActivity', 'ASC');
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), 'last_activity');

        $this->assertSame(json_encode($this->browser->getResponseData()), json_encode($sortedData));
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
        $this->authorize('developer@gmail.com'); // Authorization and creation of the first session

        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addSortQuery('lastActivity', 'DESC');
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), 'last_activity');

        $this->assertSame(json_encode($this->browser->getResponseData()), json_encode($sortedData));
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
        $this->authorize('developer@gmail.com'); // Authorization and creation of the first session

        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addSortQuery('country', 'ASC');
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), 'country');

        $this->assertSame(json_encode($this->browser->getResponseData()), json_encode($sortedData));
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
        $this->authorize('developer@gmail.com'); // Authorization and creation of the first session

        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addSortQuery('country', 'DESC');
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), 'country');

        $this->assertSame(json_encode($this->browser->getResponseData()), json_encode($sortedData));
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
        $this->authorize('developer@gmail.com'); // Authorization and creation of the first session

        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addSortQuery('city', 'ASC');
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), 'city');

        $this->assertSame(json_encode($this->browser->getResponseData()), json_encode($sortedData));
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
        $this->authorize('developer@gmail.com'); // Authorization and creation of the first session

        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addSortQuery('city', 'DESC');
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), 'city');

        $this->assertSame(json_encode($this->browser->getResponseData()), json_encode($sortedData));
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
        $this->authorize('developer@gmail.com', false); // Authorization and creation of the first session

        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addFilterQuery('isActive', 'true');
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $filteredData = $this->filter($this->browser->getResponseData(), 'is_active', true);

        $this->assertSame(json_encode($this->browser->getResponseData()), json_encode($filteredData));
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

        $authorizedUserSession = $this->authorize('developer@gmail.com', false);

        $this->browser->addFilterQuery('isActive', 'false');
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $filteredData = $this->filter($this->browser->getResponseData(), 'is_active', false);

        $this->assertSame(json_encode($this->browser->getResponseData()), json_encode($filteredData));
    }
}