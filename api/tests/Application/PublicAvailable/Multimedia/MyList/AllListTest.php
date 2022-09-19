<?php

namespace App\Tests\Application\PublicAvailable\Multimedia\MyList;

use App\Enum\AlbumTypeEnum;
use App\Enum\MultimediaTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseRequestTrait;
use App\Tests\Traits\FilterableTrait;
use App\Tests\Traits\SortableTrait;

final class AllListTest extends AbstractApiTestCase
{
    use BaseRequestTrait;
    use SortableTrait;
    use FilterableTrait;
    public const API_PATH = '/api/ru/public/user/multimedia/all';

    protected function setUp(): void
    {
        $authorizedUserSession = $this->authorize('artist@gmail.com');
        $album = $this->createAlbum($authorizedUserSession, AlbumTypeEnum::REMIX);

        $this->uploadMultimedia(
            $authorizedUserSession,
            $album,
            MultimediaTypeEnum::TRACK,
            'music_5.8mb_02-23time.wav'
        );
        $clip = $this->uploadMultimedia(
            $authorizedUserSession,
            $album,
            MultimediaTypeEnum::CLIP,
            'video_544kb_00-31time.mp4'
        );
        $this->playPauseMultimedia($clip, [$authorizedUserSession]);

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addReference('album', $album);
    }

    public function testFetchData(): void
    {
        $this->browser->sendRequest();

        foreach ($this->browser->getResponseData() as $multimedia) {
            $this->assertOnlyArrayHasKey([
                'id',
                'type',
                'title',
                'multimedia',
                'description',
                'image',
                'album',
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
            $this->assertIsString($multimedia['description']);
            $this->assertIsString($multimedia['image']);

            $this->assertIsArray($multimedia['album']);
            $this->assertOnlyArrayHasKey([
                'id',
                'type',
                'title',
                'description',
                'image',
                'created_at',
                'updated_at'
            ], $multimedia['album']);
            $this->assertIsInt($multimedia['album']['id']);

            $this->assertIsArray($multimedia['album']['type']);
            $this->assertOnlyArrayHasKey('title', $multimedia['album']['type']);
            $this->assertIsString($multimedia['album']['type']['title']);

            $this->assertIsString($multimedia['album']['title']);
            $this->assertIsString($multimedia['album']['description']);
            $this->assertIsString($multimedia['album']['image']);
            $this->assertDateTime($multimedia['album']['created_at']);
            $this->assertDateTimeWithNull($multimedia['album']['updated_at']);

            $this->assertIsArray($multimedia['category']);
            $this->assertOnlyArrayHasKey(['title'], $multimedia['category']);
            $this->assertIsString($multimedia['category']['title']);

            $this->assertIsArray($multimedia['text']);
            $this->assertIsString($multimedia['subtitles']);
            $this->assertIsString($multimedia['producer']);

            $this->assertIsArray($multimedia['performers']);

            foreach ($multimedia['performers'] as $performer) {
                $this->assertIsArray($performer);
                $this->assertOnlyArrayHasKey(['user', 'created_at', 'updated_at'], $performer);
                $this->assertIsArray($performer['user']);

                $this->assertOnlyArrayHasKey(['id'], $performer['user']);
                $this->assertIsInt($performer['user']['id']);

                $this->assertDateTime($performer['created_at']);
                $this->assertDateTimeWithNull($performer['updated_at']);
            }

            $this->assertIsBool($multimedia['is_obscene_words']);

            $this->assertIsArray($multimedia['metadata']);
            $this->assertOnlyArrayHasKey([
                'duration',
                'bitrate',
                'framerate',
                'is_lossless',
                'updated_at'
            ], $multimedia['metadata']);
            $this->assertIsFloat($multimedia['metadata']['duration']);
            $this->assertIsInt($multimedia['metadata']['bitrate']);
            $this->assertIsType(['integer', 'null'], $multimedia['metadata']['framerate']);
            $this->assertIsBool($multimedia['metadata']['is_lossless']);
            $this->assertDateTimeWithNull($multimedia['metadata']['updated_at']);

            $this->assertIsArray($multimedia['queue']);

            if ([] !== $multimedia['queue']) {
                $this->assertOnlyArrayHasKey(['id', 'created_at', 'updated_at'], $multimedia['queue']);
                $this->assertIsInt($multimedia['queue']['id']);
                $this->assertDateTime($multimedia['queue']['created_at']);
                $this->assertDateTimeWithNull($multimedia['metadata']['updated_at']);
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

    /**
     * @depends testFetchData
     */
    public function testSortByAscTitle(): void
    {
        $this->browser->addSortQuery('title', 'ASC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), 'title');

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testFetchData
     */
    public function testSortByDescTitle(): void
    {
        $this->browser->addSortQuery('title', 'DESC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), 'title');

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testFetchData
     */
    public function testSortByAscCreatedAt(): void
    {
        $this->browser->addSortQuery('createdAt', 'ASC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), 'created_at');

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testFetchData
     */
    public function testSortByDescCreatedAt(): void
    {
        $this->browser->addSortQuery('createdAt', 'DESC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), 'created_at');

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testFetchData
     */
    public function testSortByAscDuration(): void
    {
        $this->browser->addSortQuery('duration', 'ASC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), customByKey: static function(array $first, array $second) {
            return [
                $first['metadata']['duration'],
                $second['metadata']['duration'],
            ];
        });

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testFetchData
     */
    public function testSortByDescDuration(): void
    {
        $this->browser->addSortQuery('duration', 'DESC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), customByKey: static function(array $first, array $second) {
            return [
                $first['metadata']['duration'],
                $second['metadata']['duration'],
            ];
        });

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testFetchData
     */
    public function testSortByAscAuditions(): void
    {
        $this->browser->addSortQuery('auditions', 'ASC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), 'auditions');

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testFetchData
     */
    public function testSortByDescAuditions(): void
    {
        $this->browser->addSortQuery('auditions', 'DESC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), 'auditions');

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testFetchData
     */
    public function testSortByAscLike(): void
    {
        $this->browser->addSortQuery('like', 'ASC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByAsc($this->browser->getResponseData(), customByKey: static function(array $first, array $second) {
            return [
                $first['ratings']['like'],
                $second['ratings']['like']
            ];
        });

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testFetchData
     */
    public function testSortByDescLike(): void
    {
        $this->browser->addSortQuery('like', 'DESC');
        $this->browser->sendRequest();

        $sortedData = $this->sortByDesc($this->browser->getResponseData(), customByKey: static function(array $first, array $second) {
            return [
                $first['ratings']['like'],
                $second['ratings']['like']
            ];
        });

        $this->assertEquals(json_encode($sortedData), json_encode($this->browser->getResponseData()));
    }

    /**
     * @depends testFetchData
     */
    public function testFilterByType(): void
    {
        $this->browser->addFilterQuery('type', MultimediaTypeEnum::TRACK->name);
        $this->browser->sendRequest();

        $filteredData = $this->filter($this->browser->getResponseData(), 'type', MultimediaTypeEnum::TRACK->name);

        $this->assertEquals(json_encode($filteredData), json_encode($this->browser->getResponseData()));
    }
}