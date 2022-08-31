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
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
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

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testAlbumNotBelongToMe(): void
    {
        $ownerAlbum = $this->createArtistAccount('owner-album@gmail.com');
        $albumId = $this->createAlbum($this->authorize($ownerAlbum));
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->assertNotNull($albumId);
        $this->createRequest("/api/ru/public/album/{$albumId}/delete", 'DELETE', server: [
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
    public function testSuccessDelete(): void
    {
        $albumRepository = $this->em()->getRepository(Album::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$albumId}/delete", 'DELETE', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertNull($albumRepository->find($albumId));
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
        $albumRepository = $this->em()->getRepository(Album::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $album = $albumRepository->find($this->createAlbum($authorizedUser));

        $this->createRequest("/api/ru/public/album/{$album->getId()}/delete", 'DELETE', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

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
        $albumRepository = $this->em()->getRepository(Album::class);
        $multimediaRepository = $this->em()->getRepository(Multimedia::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $album = $albumRepository->find($this->createAlbum($authorizedUser)); // TODO: В созданный альбом, добавить мультимедиа

        $this->createRequest("/api/ru/public/album/{$album->getId()}/delete", 'DELETE', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

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