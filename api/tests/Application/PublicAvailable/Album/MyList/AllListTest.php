<?php

namespace App\Tests\Application\PublicAvailable\Album\MyList;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseRequestTrait;

final class AllListTest extends AbstractApiTestCase
{
    use BaseRequestTrait;
    public const API_PATH = '/api/ru/public/album/all';

    protected function setUp(): void
    {
        $authorizedUserSession = $this->authorize('artist@gmail.com');

        $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setBearerAuth($authorizedUserSession);
    }

    public function testFetchData(): void
    {
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DATA_OUTPUT);
        $this->assertApiMessage('Вывод данных');
        $this->assertNotEmpty($this->browser->getResponseData());

        foreach ($this->browser->getResponseData() as $data) {
            $this->assertIsArray($data);
            $this->assertOnlyArrayHasKey([
                'id',
                'type',
                'title',
                'description',
                'image',
                'multimedia',
                'created_at',
                'updated_at'
            ], $data);

            $this->assertIsInt($data['id']);
            $this->assertIsArray($data['type']);
            $this->assertIsString($data['title']);
            $this->assertIsString($data['description']);
            $this->assertIsString($data['image']);
            $this->assertIsArray($data['multimedia']);
            $this->assertDateTime($data['created_at']);
            $this->assertDateTimeWithNull($data['updated_at']);
            $this->assertArrayHasKey('title', $data['type']);
            $this->assertIsString($data['type']['title']);

            foreach ($data['multimedia'] as $multimedia) {
                $this->assertIsArray($multimedia);
                $this->assertOnlyArrayHasKey([
                    'id',
                    'type',
                    'title',
                    'description',
                    'image',
                    'category',
                    'text',
                    'subtitles',
                    'producer',
                    'performers',
                    'is_obscene_words',
                    'metadata',
                    'queue',
                    'shares',
                    'auditions',
                    'ratings',
                    'status',
                    'created_at',
                    'updated_at'
                ], $multimedia);

                $this->assertIsInt($multimedia['id']);
                $this->assertIsString($multimedia['type']);
                $this->assertIsString($multimedia['title']);
                $this->assertIsString($multimedia['multimedia']);
                $this->assertIsType(['string', 'null'], $multimedia['description']);
                $this->assertIsString($multimedia['image']);

                $this->assertIsArray($multimedia['category']);
                $this->assertOnlyArrayHasKey('title', $multimedia['category']);
                $this->assertIsString($multimedia['category']['title']);

                $this->assertIsType(['array', 'null'], $multimedia['text']);
                $this->assertIsType(['string', 'null'], $multimedia['subtitles']);
                $this->assertIsString($multimedia['producer']);

                $this->assertIsArray($multimedia['performers']);

                foreach ($multimedia['performers'] as $performer) {
                    $this->assertIsArray($performer);
                    $this->assertOnlyArrayHasKey(['user', 'created_at', 'updated_at'], $performer);

                    $this->assertIsInt($performer['user']['id']);
                    $this->assertDateTime($performer['created_at']);
                    $this->assertDateTimeWithNull($performer['updated_at']);
                }

                $this->assertIsBool($multimedia['is_obscene_words']);

                $this->assertIsArray($multimedia['metadata']);
                $this->assertIsFloat($multimedia['metadata']['duration']);
                $this->assertIsInt($multimedia['metadata']['bitrate']);
                $this->assertIsType(['integer', 'null'], $multimedia['metadata']['framerate']);
                $this->assertIsBool($multimedia['metadata']['is_lossless']);
                $this->assertDateTimeWithNull($multimedia['metadata']['updated_at']);

                $this->assertIsArray($multimedia['queue']);

                if ([] !== $multimedia['queue']) {
                    $this->assertOnlyArrayHasKey(['id', 'created_at', 'updated_at'], $multimedia['queue']);
                    $this->assertDateTime($multimedia['queue']['created_at']);
                    $this->assertDateTimeWithNull($multimedia['queue']['updated_at']);
                }

                $this->assertIsInt($multimedia['shares']);
                $this->assertIsInt($multimedia['auditions']);

                $this->assertIsArray($multimedia['ratings']);
                $this->assertOnlyArrayHasKey(['like', 'dislike'], $multimedia['ratings']);
                $this->assertIsInt($multimedia['ratings']['like']);
                $this->assertIsInt($multimedia['ratings']['dislike']);

                $this->assertIsString($multimedia['status']);
                $this->assertDateTime($multimedia['created_at']);
                $this->assertDateTimeWithNull($multimedia['updated_at']);
            }
        }
    }
}