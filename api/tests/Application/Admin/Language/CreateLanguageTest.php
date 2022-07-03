<?php

namespace App\Tests\Application\Admin\Language;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;

/**
 * Class CreateLanguageTest.
 *
 * @package App\Tests\Application\Admin\Language
 *
 * @author  Codememory
 */
final class CreateLanguageTest extends AbstractApiTestCase
{
    public function testValidation(): void
    {
        $this->createRequest('/api/ru/admin/language/create', 'POST', [
            'code' => null,
            'original_title' => null
        ]);

        $this->assertApiResponse();
        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION->name);
        $this->assertApiMessage([
            'code' => 'Длина кода не должна быть меньше 2-х символов',
            'originalTitle' => 'Название языка обязательно к заполнению'
        ]);
    }

    public function testMaxCodeLength(): void
    {
        $this->createRequest('/api/ru/admin/language/create', 'POST', [
            'code' => 'russian',
            'original_title' => 'Название языка'
        ]);

        $this->assertApiResponse();
        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION->name);
        $this->assertApiMessage([
            'code' => 'Длина кода не должна превышать 5 символов'
        ]);
    }

    public function testExistCode(): void
    {
        $this->createRequest('/api/ru/admin/language/create', 'POST', [
            'code' => 'ru',
            'original_title' => 'Русский'
        ]);

        $this->assertApiResponse();
        $this->assertApiStatusCode(409);
        $this->assertApiType(ResponseTypeEnum::EXIST->name);
        $this->assertApiMessage([
            'code' => 'Данный код языка уже существует'
        ]);
    }

    public function testSuccessCreate(): void
    {
        $this->createRequest('/api/ru/admin/language/create', 'POST', [
            'code' => 'tt',
            'original_title' => 'Тестовый язык'
        ]);

        $this->assertApiResponse();
        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::CREATE->name);
        $this->assertApiMessage('Язык успешно создан');
    }
}