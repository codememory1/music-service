<?php

namespace App\Tests\Application\PublicAvailable\Translation;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\FilterableTrait;

final class AllTranslationTest extends AbstractApiTestCase
{
    use FilterableTrait;
    public const API_PATH = '/api/ru/public/translation/{locale}/all';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
    }

    public function testLanguageNotFound(): void
    {
        $this->browser->addParameter('locale', 'mmm');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@language');
    }

    public function testReturnTranslations(): void
    {
        $this->browser->addParameter('locale', 'ru');
        $this->browser->sendRequest();

        foreach ($this->browser->getResponseData() as $data) {
            $this->assertIsArray($data);
            $this->assertOnlyArrayHasKey(['translation_key', 'translation'], $data);
            $this->assertIsArray($data['translation_key']);
            $this->assertIsString($data['translation']);
            $this->assertIsString($data['translation_key']['key']);
        }
    }

    public function testFilterByGroup(): void
    {
        $this->browser->addParameter('locale', 'ru');
        $this->browser->addFilterQuery('group', 'entityNotFound');
        $this->browser->sendRequest();

        $filteredData = $this->filterByCallback($this->browser->getResponseData(), static fn(array $item) => str_starts_with($item['translation_key']['key'], 'entityNotFound@'));

        $this->assertEquals(json_encode($filteredData), json_encode($this->browser->getResponseData()));
    }

    public function testFilterByKey(): void
    {
        $this->browser->addParameter('locale', 'ru');
        $this->browser->addFilterQuery('key', 'entityNotFound@album');
        $this->browser->sendRequest();

        $filteredData = $this->filterByCallback($this->browser->getResponseData(), static fn(array $item) => 'entityNotFound@album' === $item['translation_key']['key']);

        $this->assertEquals(json_encode($filteredData), json_encode($this->browser->getResponseData()));
    }
}