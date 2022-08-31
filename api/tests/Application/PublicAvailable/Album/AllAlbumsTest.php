<?php

namespace App\Tests\Application\PublicAvailable\Album;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class AllAlbumsTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;

    public function testAuthorizeIsRequired(): void
    {
        $this->createRequest('/api/ru/public/album/all', 'GET');

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
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
            $this->assertDateTime($data['created_at']);
            $this->assertDateTimeWithNull($data['updated_at']);
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
                $this->assertArrayHasKey('title', $multimedia['category']);
                $this->assertIsString($multimedia['category']['title']);

                $this->assertIsType(['array', 'null'], $multimedia['text']);
                $this->assertIsType(['string', 'null'], $multimedia['subtitles']);
                $this->assertIsString($multimedia['producer']);

                $this->assertIsArray($multimedia['performers']);

                foreach ($multimedia['performers'] as $performer) {
                    $this->assertIsArray($performer);
                    $this->assertArrayHasKey('user', $performer);
                    $this->assertArrayHasKey('created_at', $performer);
                    $this->assertArrayHasKey('updated_at', $performer);

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
                    $this->assertArrayNotHasKey('id', $multimedia['queue']);
                    $this->assertArrayNotHasKey('created_at', $multimedia['queue']);
                    $this->assertArrayNotHasKey('updated_at', $multimedia['queue']);
                    $this->assertDateTime($multimedia['queue']['created_at']);
                    $this->assertDateTimeWithNull($multimedia['queue']['updated_at']);
                }

                $this->assertIsInt($multimedia['shares']);
                $this->assertIsInt($multimedia['auditions']);

                $this->assertIsArray($multimedia['ratings']);
                $this->assertArrayHasKey('like', $multimedia['ratings']);
                $this->assertArrayHasKey('dislike', $multimedia['ratings']);
                $this->assertIsInt($multimedia['ratings']['like']);
                $this->assertIsInt($multimedia['ratings']['dislike']);

                $this->assertIsString($multimedia['status']);
                $this->assertDateTime($multimedia['created_at']);
                $this->assertDateTimeWithNull($multimedia['updated_at']);
            }
        }
    }
}