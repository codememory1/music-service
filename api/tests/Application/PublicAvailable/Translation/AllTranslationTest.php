<?php

namespace App\Tests\Application\PublicAvailable\Translation;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;

final class AllTranslationTest extends AbstractApiTestCase
{
    public function testLanguageNotFound(): void
    {
        $this->createRequest('/api/ru/public/translation/mmm/all', 'GET');

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@language');
    }

    public function testReturnTranslations(): void
    {
        $this->createRequest('/api/ru/public/translation/ru/all', 'GET');

        foreach ($this->getApiResponseData() as $data) {
            $this->assertIsArray($data);
            $this->assertArrayHasKey('translation_key', $data);
            $this->assertArrayHasKey('translation', $data);
            $this->assertIsArray($data['translation_key']);
            $this->assertIsString($data['translation']);
            $this->assertIsString($data['translation_key']['key']);
        }
    }
}