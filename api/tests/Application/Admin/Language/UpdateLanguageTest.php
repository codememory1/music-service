<?php

namespace App\Tests\Application\Admin\Language;

use App\Entity\Language;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;

/**
 * Class UpdateLanguageTest.
 *
 * @package App\Tests\Application\Admin\Language
 *
 * @author  Codememory
 */
final class UpdateLanguageTest extends AbstractApiTestCase
{
    private ?int $languageId = null;

    public function setUp(): void
    {
        $languageRepository = $this->em->getRepository(Language::class);

        $this->laguageId = $languageRepository->findOneBy(['code' => 'ru'])?->getId();
    }

    public function testNotExist(): void
    {
        $this->createRequest('/api/ru/admin/language/0/edit', 'PUT');

        $this->assertApiResponse();
        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST->name);
        $this->assertApiMessage('Язык не найден');
    }

//    public function testValidation(): void
//    {
//        $this->createRequest("/api/ru/admin/language/{$this->languageId}/edit", 'PUT', [
//            'code' => null,
//            'original_title' => null
//        ]);
//
//        $this->assertApiResponse();
//        $this->assertApiStatusCode(422);
//        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION->name);
//        $this->assertApiMessage([
//            'code' => 'Длина кода не должна быть меньше 2-х символов',
//            'originalTitle' => 'Название языка обязательно к заполнению'
//        ]);
//    }
//
//    public function testMaxCodeLength(): void
//    {
//        $this->createRequest("/api/ru/admin/language/{$this->languageId}/edit", 'PUT', [
//            'code' => 'russian',
//            'original_title' => 'Название языка'
//        ]);
//
//        $this->assertApiResponse();
//        $this->assertApiStatusCode(422);
//        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION->name);
//        $this->assertApiMessage([
//            'code' => 'Длина кода не должна превышать 5 символов'
//        ]);
//    }
//
//    public function testExistCode(): void
//    {
//        $this->createRequest("/api/ru/admin/language/{$this->languageId}/edit", 'PUT', [
//            'code' => 'en',
//            'original_title' => 'English'
//        ]);
//
//        $this->assertApiResponse();
//        $this->assertApiStatusCode(409);
//        $this->assertApiType(ResponseTypeEnum::EXIST->name);
//        $this->assertApiMessage([
//            'code' => 'Данный код языка уже существует'
//        ]);
//    }
//
//    public function testSuccessUpdate(): void
//    {
//        $this->createRequest("/api/ru/admin/language/{$this->languageId}/edit", 'PUT', [
//            'code' => 'ru',
//            'original_title' => 'Русский 2'
//        ]);
//
//        $this->assertApiResponse();
//        $this->assertApiStatusCode(200);
//        $this->assertApiType(ResponseTypeEnum::UPDATE->name);
//        $this->assertApiMessage('Язык успешно обновлен');
//    }
}