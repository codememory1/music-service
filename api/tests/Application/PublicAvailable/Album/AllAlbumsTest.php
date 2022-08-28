<?php

namespace App\Tests\Application\PublicAvailable\Album;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;

final class AllAlbumsTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;
    private const DATE_TIME_PATTERN = '/^([0-9]{4}-[0-9]{01,12}-[0-9]{01,31}\s[0-9]{00,24}:[0-9]{00,24}:[0-9]{00,60})|(\s*)$/';

    public function testAuthorizeIsRequired(): void
    {
        $this->createRequest('/api/ru/public/album/all', 'GET');

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    public function testReturnAlbums(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createAlbum($authorizedUser);

        $this->createRequest('/api/ru/public/album/all', 'GET', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DATA_OUTPUT);
        $this->assertApiMessage('Вывод данных');

        foreach ($this->getApiResponseData() as $data) {
            $this->assertIsArray($data);
            $this->assertArrayHasKey('id', $data);
            $this->assertArrayHasKey('type', $data);
            $this->assertArrayHasKey('title', $data);
            $this->assertArrayHasKey('description', $data);
            $this->assertArrayHasKey('image', $data);
            $this->assertArrayHasKey('multimedia', $data);
            $this->assertArrayHasKey('created_at', $data);
            $this->assertArrayHasKey('updated_at', $data);
            $this->assertIsInt($data['id']);
            $this->assertIsArray($data['type']);
            $this->assertIsString($data['title']);
            $this->assertIsString($data['description']);
            $this->assertIsString($data['image']);
            $this->assertIsArray($data['multimedia']);
            $this->assertMatchesRegularExpression(self::DATE_TIME_PATTERN, $data['created_at']);
            $this->assertMatchesRegularExpression(self::DATE_TIME_PATTERN, $data['updated_at'] ?: '');
            $this->assertArrayHasKey('title', $data['type']);
            $this->assertIsString($data['type']['title']);

            foreach ($data['multimedia'] as $multimedia) {
                $this->assertIsArray($multimedia);
                $this->assertArrayHasKey('id', $multimedia);
                $this->assertArrayHasKey('type', $multimedia);
                $this->assertArrayHasKey('title', $multimedia);
                $this->assertArrayHasKey('multimedia', $multimedia);
                $this->assertArrayHasKey('description', $multimedia);
                $this->assertArrayHasKey('image', $multimedia);
                $this->assertArrayHasKey('category', $multimedia);
                $this->assertArrayHasKey('text', $multimedia);
                $this->assertArrayHasKey('subtitles', $multimedia);
                $this->assertArrayHasKey('producer', $multimedia);
                $this->assertArrayHasKey('performers', $multimedia);
                $this->assertArrayHasKey('is_obscene_words', $multimedia);
                $this->assertArrayHasKey('metadata', $multimedia);
                $this->assertArrayHasKey('queue', $multimedia);
                $this->assertArrayHasKey('shares', $multimedia);
                $this->assertArrayHasKey('auditions', $multimedia);
                $this->assertArrayHasKey('ratings', $multimedia);
                $this->assertArrayHasKey('status', $multimedia);
                $this->assertArrayHasKey('created_at', $multimedia);
                $this->assertArrayHasKey('updated_at', $multimedia);
                $this->assertIsInt($multimedia['id']);
                $this->assertIsString($multimedia['type']);
                $this->assertIsString($multimedia['title']);
                $this->assertIsString($multimedia['multimedia']);
                $this->assertIsType(['string', 'null'], $multimedia['description']);
                $this->assertIsString($multimedia['image']);
                $this->assertIsArray($multimedia['category']);
                $this->assertIsType(['array', 'null'], $multimedia['text']);
                $this->assertIsType(['string', 'null'], $multimedia['subtitles']);
                $this->assertIsString($multimedia['producer']);
                $this->assertIsArray($multimedia['performers']);
                $this->assertIsBool($multimedia['is_obscene_words']);
                $this->assertIsArray($multimedia['metadata']);
                $this->assertIsArray($multimedia['queue']);
                $this->assertIsInt($multimedia['shares']);
                $this->assertIsInt($multimedia['auditions']);
                $this->assertIsArray($multimedia['ratings']);
                $this->assertIsString($multimedia['status']);
                $this->assertMatchesRegularExpression(self::DATE_TIME_PATTERN, $multimedia['created_at']);
                $this->assertMatchesRegularExpression(self::DATE_TIME_PATTERN, $multimedia['updated_at'] ?: '');
            }
        }
    }
}