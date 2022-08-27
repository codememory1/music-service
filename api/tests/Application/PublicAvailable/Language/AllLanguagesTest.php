<?php

namespace App\Tests\Application\PublicAvailable\Language;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\SortableTrait;

final class AllLanguagesTest extends AbstractApiTestCase
{
    use SortableTrait;

    public function testReturnLanguages(): void
    {
        $this->createRequest('/api/ru/public/language/all', 'GET');

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DATA_OUTPUT);
        $this->assertApiMessage('Вывод данных');

        foreach ($this->getApiResponseData() as $data) {
            $this->assertIsArray($data);
            $this->assertArrayHasKey('code', $data);
            $this->assertArrayHasKey('original_title', $data);
        }
    }

    /**
     * @depends testReturnLanguages
     */
    public function testSortAscByCode(): void
    {
        $this->createRequest('/api/ru/public/language/all?sort[0][name]=code&sort[0][value]=ASC', 'GET');

        $sortedData = $this->sortByAsc($this->getApiResponseData(), 'code');

        $this->assertEquals(json_encode($sortedData), json_encode($this->getApiResponseData()));
    }

    /**
     * @depends testReturnLanguages
     */
    public function testSortDescByCode(): void
    {
        $this->createRequest('/api/ru/public/language/all?sort[0][name]=code&sort[0][value]=DESC', 'GET');

        $sortedData = $this->sortByDesc($this->getApiResponseData(), 'code');

        $this->assertEquals(json_encode($sortedData), json_encode($this->getApiResponseData()));
    }

    /**
     * @depends testReturnLanguages
     */
    public function testSortAscByTitle(): void
    {
        $this->createRequest('/api/ru/public/language/all?sort[0][name]=title&sort[0][value]=ASC', 'GET');

        $sortedData = $this->sortByAsc($this->getApiResponseData(), 'original_title');

        $this->assertEquals(json_encode($sortedData), json_encode($this->getApiResponseData()));
    }

    /**
     * @depends testReturnLanguages
     */
    public function testSortDescByTitle(): void
    {
        $this->createRequest('/api/ru/public/language/all?sort[0][name]=title&sort[0][value]=DESC', 'GET');

        $sortedData = $this->sortByDesc($this->getApiResponseData(), 'original_title');

        $this->assertEquals(json_encode($sortedData), json_encode($this->getApiResponseData()));
    }
}