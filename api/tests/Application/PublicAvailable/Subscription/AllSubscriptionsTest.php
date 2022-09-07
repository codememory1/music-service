<?php

namespace App\Tests\Application\PublicAvailable\Subscription;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;

final class AllSubscriptionsTest extends AbstractApiTestCase
{
    public const API_PATH = '/api/ru/public/subscription/all';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
    }

    public function testReturnSubscriptions(): void
    {
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DATA_OUTPUT);
        $this->assertApiMessage('Вывод данных');

        foreach ($this->browser->getResponseData() as $data) {
            $this->assertIsArray($data);
            $this->assertOnlyArrayHasKey([
                'id',
                'title',
                'description',
                'old_price',
                'price',
                'is_recommend',
                'status',
                'permissions'
            ], $data);

            $this->assertIsInt($data['id']);
            $this->assertIsString($data['title']);
            $this->assertIsType(['string', 'null'], $data['description']);
            $this->assertIsType(['double', 'integer', 'null'], $data['old_price']);
            $this->assertIsType(['double', 'integer'], $data['price']);
            $this->assertIsBool($data['is_recommend']);
            $this->assertIsString($data['status']);
            $this->assertIsArray($data['permissions']);

            foreach ($data['permissions'] as $permission) {
                $this->assertIsArray($permission);
                $this->assertOnlyArrayHasKey('permission_key', $permission);
                $this->assertIsArray($permission['permission_key']);
                $this->assertOnlyArrayHasKey('title', $permission['permission_key']);
                $this->assertIsString($permission['permission_key']['title']);
            }
        }
    }
}