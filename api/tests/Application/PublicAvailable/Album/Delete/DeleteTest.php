<?php

namespace App\Tests\Application\PublicAvailable\Album\Delete;

use App\Entity\Album;
use App\Entity\Multimedia;
use App\Enum\MultimediaTypeEnum;
use App\Enum\ResponseTypeEnum;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseRequestTrait;
use Symfony\Component\HttpFoundation\Request;

final class DeleteTest extends AbstractApiTestCase
{
    use BaseRequestTrait;
    public const API_PATH = '/api/ru/public/album/{id}/delete';

    protected function setUp(): void
    {
        $authorizedUserSession = $this->authorize('artist@gmail.com');
        $album = $this->createAlbum($authorizedUserSession);
        $albumNotBelongToAuthorizedUserSession = $this->createAlbum($this->authorize('artist2@gmail.com'));

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_DELETE);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addReference('album', $album);
        $this->browser->addReference('albumNotBelongToAuthorizedUser', $albumNotBelongToAuthorizedUserSession);
        $this->browser->addReference('authorizedUserSession', $authorizedUserSession);
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
        $this->browser->addParameter('id', $this->browser->getReference('albumNotBelongToAuthorizedUser')->getId());
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    public function testSuccessDelete(): void
    {
        $albumRepository = $this->em()->getRepository(Album::class);
        $album = $this->browser->getReference('album');

        $this->browser->addParameter('id', $album->getId());
        $this->browser->sendRequest();

        $this->em()->clear();

        $this->assertNull($albumRepository->find($album->getId()));
        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DELETE);
        $this->assertApiMessage('Альбом успешно удален');
    }

    /**
     * @depends testSuccessDelete
     */
    public function testSuccessDeleteImageToS3(): void
    {
        $imageUploader = $this->getService(ImageUploader::class);
        $album = $this->browser->getReference('album');

        $this->browser->addParameter('id', $album->getId());
        $this->browser->sendRequest();

        $this->assertNull($imageUploader->getObject($album->getImage()));
    }

    /**
     * @depends testSuccessDelete
     */
    public function testSuccessDeleteMultimedia(): void
    {
        $imageUploader = $this->getService(ImageUploader::class);
        $trackUploader = $this->getService(TrackUploader::class);
        $clipUploader = $this->getService(ClipUploader::class);
        $multimediaRepository = $this->em()->getRepository(Multimedia::class);
        $album = $this->browser->getReference('album');
        $this->uploadMultimedia(
            $this->browser->getReference('authorizedUserSession'),
            $this->browser->getReference('album'),
            MultimediaTypeEnum::TRACK,
            'music_5.8mb_02-23time.wav'
        );

        $this->browser->addParameter('id', $album->getId());
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