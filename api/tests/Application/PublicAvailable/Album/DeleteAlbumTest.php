<?php

namespace App\Tests\Application\PublicAvailable\Album;

use App\Entity\Album;
use App\Entity\Multimedia;
use App\Enum\MultimediaTypeEnum;
use App\Enum\ResponseTypeEnum;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class DeleteAlbumTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;
    public const API_PATH = '/api/ru/public/album/{id}/delete';

    public function testAuthorizeIsRequired(): void
    {
        $this->browser->createRequest(self::API_PATH, ['id' => 0]);
        $this->browser->setMethod(Request::METHOD_DELETE);
        $this->browser->sendRequest();

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
    public function testAlbumNotExist(): void
    {
        $this->browser->createRequest(self::API_PATH, ['id' => 0]);
        $this->browser->setMethod(Request::METHOD_DELETE);
        $this->browser->setBearerAuth($this->authorize('developer@gmail.com'));
        $this->browser->sendRequest();

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
        $albumOwnerSession = $this->authorize($this->createArtistAccount('owner-album@gmail.com'));
        $album = $this->createAlbum($albumOwnerSession);
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_DELETE);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

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
    public function testSuccessDelete(): void
    {
        $albumRepository = $this->em()->getRepository(Album::class);
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_DELETE);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->em()->clear();

        $this->assertNull($albumRepository->find($album->getId()));
        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DELETE);
        $this->assertApiMessage('Альбом успешно удален');
    }

    /**
     * @depends testSuccessDelete
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSuccessDeleteImageToS3(): void
    {
        $imageUploader = $this->getService(ImageUploader::class);
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_DELETE);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertNull($imageUploader->getObject($album->getImage()));
    }

    /**
     * @depends testSuccessDelete
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSuccessDeleteMultimedia(): void
    {
        $imageUploader = $this->getService(ImageUploader::class);
        $trackUploader = $this->getService(TrackUploader::class);
        $clipUploader = $this->getService(ClipUploader::class);
        $multimediaRepository = $this->em()->getRepository(Multimedia::class);
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession); // TODO: В созданный альбом, добавить мультимедиа

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_DELETE);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        foreach ($album->getMultimedia() as $multimedia) {
            $this->assertNull($imageUploader->getObject($multimedia->getImage()));

            if ($multimedia->getType() === MultimediaTypeEnum::TRACK->name) {
                $this->assertNull($trackUploader->getObject($multimedia->getMultimedia()));
            }

            if ($multimedia->getType() === MultimediaTypeEnum::CLIP->name) {
                $this->assertNull($clipUploader->getObject($multimedia->getMultimedia()));
            }

            $this->assertNull($multimediaRepository->find($multimedia->getId()));
        }
    }
}