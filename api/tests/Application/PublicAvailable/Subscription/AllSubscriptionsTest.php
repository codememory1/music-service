<?php

namespace App\Tests\Application\PublicAvailable\Subscription;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;

final class AllSubscriptionsTest extends AbstractApiTestCase
{
    public function testReturnSubscriptions(): void
    {
        $this->createRequest('/api/ru/public/subscription/all', 'GET');

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DATA_OUTPUT);
        $this->assertApiMessage('Вывод данных');

        foreach ($this->getApiResponseData() as $data) {
            $this->assertIsArray($data);
            $this->assertArrayHasKey('id', $data);
            $this->assertArrayHasKey('title', $data);
            $this->assertArrayHasKey('description', $data);
            $this->assertArrayHasKey('old_price', $data);
            $this->assertArrayHasKey('price', $data);
            $this->assertArrayHasKey('is_recommend', $data);
            $this->assertArrayHasKey('status', $data);
            $this->assertArrayHasKey('permissions', $data);

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
                $this->assertArrayHasKey('permission_key', $permission);
                $this->assertIsArray($permission['permission_key']);
                $this->assertArrayHasKey('title', $permission['permission_key']);
                $this->assertIsString($permission['permission_key']['title']);
            }
        }
    }
}