<?php

namespace App\Tests\Application\PublicAvailable\Album;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;
use Symfony\Component\HttpFoundation\Request;

final class PublishAlbumTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;
    public const API_PATH = '/api/ru/public/album/{id}/publish';

    public function testAuthorizeIsRequired(): void
    {
        $this->browser->createRequest(self::API_PATH, ['id' => 0]);
        $this->browser->setMethod(Request::METHOD_PATCH);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    public function testAccessDenied(): void
    {
        $album = $this->createAlbum($this->authorize($this->createArtistAccount()));
        $authorizedUserSession = $this->authorize('user@gmail.com');

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_PATCH);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(403);
        $this->assertApiType(ResponseTypeEnum::CHECK_ACCESS);
        $this->assertApiMessage('accessDenied@notSubscriptionPermissions');
    }

    public function testAlbumNotExist(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());

        $this->browser->createRequest(self::API_PATH, ['id' => 0]);
        $this->browser->setMethod(Request::METHOD_PATCH);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    public function testAlbumNotBelongToMe(): void
    {
        $album = $this->createAlbum($this->authorize($this->createArtistAccount()));
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_PATCH);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    public function testBadPublicationWithoutMultimedia(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_PATCH);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::FAILED);
        $this->assertApiMessage('album@badPublicationWithoutPublishedMultimedia');
    }

    public function testSuccessPublish(): void
    {
        // TODO: Пока невозможно опубликовать без мультимедиа - доработать после запроса создания мультимедиа
    }
}