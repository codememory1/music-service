<?php

namespace App\Tests\Traits;

use App\Enum\ResponseTypeEnum;
use function gettype;
use function is_array;

trait AssertTrait
{
    protected function assertApiStatusCode(int $expect, ?string $message = null): void
    {
        $this->assertEquals($expect, $this->response['status_code'], $message ?? '');
    }

    protected function assertApiType(ResponseTypeEnum $expect, ?string $message = null): void
    {
        $this->assertEquals($expect->name, $this->response['type'], $message ?? '');
    }

    protected function assertApiMessage(string|array $expect, ?string $message = null): void
    {
        $this->assertEquals($expect, $this->response['message'], $message ?? '');
    }

    protected function assertApiData(array $expect, ?string $message = null): void
    {
        $this->assertEquals($expect, $this->response['data'], $message ?? '');
    }

    protected function assertIsType(string|array $expect, mixed $value, ?string $message = null): void
    {
        $valueType = mb_strtolower(gettype($value));
        $expectTypes = is_array($expect) ? $expect : [$expect];
        $expectTypesToString = implode(',', $expect);
        $isType = false;

        foreach ($expectTypes as $expectType) {
            if ($valueType === $expectType) {
                $isType = true;

                break;
            }
        }

        $this->assertTrue($isType, $message ?: "Failed to validate that the value is one of the \"${expectTypesToString}\" types.");
    }

    protected function assertCreatedAt(mixed $actual, string $message = ''): void
    {
        $this->assertIsString($actual);
        $this->assertMatchesRegularExpression(
            '/^[0-9]{4}-[0-9]{01,12}-[0-9]{01,31}\s[0-9]{00,24}:[0-9]{00,24}:[0-9]{00,60}$/',
            $actual,
            $message
        );
    }

    protected function assertUpdatedAt(mixed $actual, string $message = ''): void
    {
        $this->assertIsString($actual ?: '');
        $this->assertMatchesRegularExpression(
            '/^([0-9]{4}-[0-9]{01,12}-[0-9]{01,31}\s[0-9]{00,24}:[0-9]{00,24}:[0-9]{00,60})|(\s*)$/',
            $actual ?: '',
            $message
        );
    }
}