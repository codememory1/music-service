<?php

namespace App\Tests\Application\PublicAvailable\Album\Publish;

use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseRequestTrait;
use Symfony\Component\HttpFoundation\Request;

final class PublishTest extends AbstractApiTestCase
{
    use BaseRequestTrait;
    public const API_PATH = '/api/ru/public/album/{id}/publish';

    protected function setUp(): void
    {
        $authorizedUserSession = $this->authorize('artist@gmail.com');
        $album = $this->createAlbum($authorizedUserSession);
        $albumSecond = $this->createAlbum($this->authorize('artist2@gmail.com'));

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_PATCH);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addReference('album', $album);
        $this->browser->addReference('albumNotBelongToAuthorizedUserSession', $albumSecond);
    }

    public function testAlbumNotExist(): void
    {
        $this->browser->addParameter('id', 0);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    public function testAlbumNotBelongToMe(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('albumNotBelongToAuthorizedUserSession')->getId());
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    public function testBadPublicationWithoutMultimedia(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
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