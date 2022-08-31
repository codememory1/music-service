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

final class PublishAlbumTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;

    public function testAuthorizeIsRequired(): void
    {
        $this->createRequest('/api/ru/public/album/0/publish', 'PATCH');

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testAccessDenied(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);
        $authorizedUser = $this->authorize('user@gmail.com');

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/publish", 'PATCH', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(403);
        $this->assertApiType(ResponseTypeEnum::CHECK_ACCESS);
        $this->assertApiMessage('accessDenied@notSubscriptionPermissions');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testAlbumNotExist(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/0/publish', 'PATCH', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testAlbumNotBelongToMe(): void
    {
        $ownerAlbum = $this->authorize($this->createArtistAccount('owner-album@gmail.com'));
        $albumId = $this->createAlbum($ownerAlbum);
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->assertNotNull($albumId);
        $this->createRequest("/api/ru/public/album/{$albumId}/publish", 'PATCH', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testBadPublicationWithoutMultimedia(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$albumId}/publish", 'PATCH', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::FAILED);
        $this->assertApiMessage('album@badPublicationWithoutPublishedMultimedia');
    }

    public function testSuccessPublish(): void
    {
        // TODO: Пока невозможно опубликовать без мультимедиа - доработать после запроса создания мультимедиа
    }
}