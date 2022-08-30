<?php

namespace App\Tests\Application\PublicAvailable\Album;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;

final class DeleteAlbumTest extends AbstractApiTestCase
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

    public function testAlbumNotExist(): void
    {
        $authorizedUser = $this->authorize('developer@gmail.com');
        $this->createRequest('/api/ru/public/album/0/delete', 'DELETE', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    public function testAlbumNotExistIfAlbumNotBelongMe(): void
    {
        $ownerAlbum = $this->createArtistAccount('owner-album@gmail.com');
        $albumId = $this->createAlbum($this->authorize($ownerAlbum));
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest("/api/ru/public/album/{$albumId}/delete", 'DELETE', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    public function testSuccessDelete(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$albumId}/delete", 'DELETE', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DELETE);
        $this->assertApiMessage('Альбом успешно удален');
    }

    public function testSuccessDeleteImageToS3(): void
    {
    }

    public function testSuccessDeleteMultimedia(): void
    {
    }
}