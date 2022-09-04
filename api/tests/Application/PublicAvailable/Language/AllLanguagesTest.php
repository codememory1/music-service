<?php

namespace App\Tests\Application\PublicAvailable\Language;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\SortableTrait;

final class AllLanguagesTest extends AbstractApiTestCase
{
    use SortableTrait;
    public const API_PATH = '/api/ru/public/language/all';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
    }

    public function testReturnLanguages(): void
    {
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DATA_OUTPUT);
        $this->assertApiMessage('Вывод данных');

        foreach ($this->browser->getResponseData() as $data) {
            $this->assertIsArray($data);
            $this->assertOnlyArrayHasKey(['code', 'original_title'], $data);
            $this->assertIsString($data['code']);
            $this->assertIsString($data['original_title']);
            $this->assertLessThan(3, mb_strlen($data['code']));
        }
    }

    /**
     * @depends testReturnLanguages
     */
    public function testSortAscByCode(): void
    {
        $this->browser->addSortQuery('code', 'ASC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), 'code');

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testReturnLanguages
     */
    public function testSortDescByCode(): void
    {
        $this->browser->addSortQuery('code', 'DESC');

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), 'code');

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testReturnLanguages
     */
    public function testSortAscByTitle(): void
    {
        $this->browser->addSortQuery('title', 'ASC');

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), 'original_title');

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testReturnLanguages
     */
    public function testSortDescByTitle(): void
    {
        $this->browser->addSortQuery('title', 'DESC');

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), 'original_title');

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }
}