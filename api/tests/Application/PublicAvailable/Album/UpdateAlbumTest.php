<?php

namespace App\Tests\Application\PublicAvailable\Album;

use App\Entity\Album;
use App\Entity\UserSession;
use App\Enum\AlbumTypeEnum;
use App\Enum\ResponseTypeEnum;
use App\Rest\S3\Uploader\ImageUploader;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;
use Symfony\Component\HttpFoundation\Request;

final class UpdateAlbumTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;
    public const API_PATH = '/api/ru/public/album/{id}/edit';
    private array $validateData = [
        'type' => AlbumTypeEnum::DOUBLE,
        'title' => 'Battle grounds edit',
        'description' => 'Edited album description',
        'image' => 'image_2mb.png'
    ];

    public function testAuthorizeIsRequired(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    public function testAccessDenied(): void
    {
        $albumOwnerSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($albumOwnerSession);
        $authorizedUserSession = $this->authorize('user@gmail.com');

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(403);
        $this->assertApiType(ResponseTypeEnum::CHECK_ACCESS);
        $this->assertApiMessage('accessDenied@notSubscriptionPermissions');
    }

    public function testAlbumNotExist(): void
    {
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->createRequest(self::API_PATH, ['id' => 0]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    public function testAlbumNotBelongToMe(): void
    {
        $albumOwnerSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($albumOwnerSession);
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    public function testTypeIsRequired(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@typeIsRequired');
    }

    public function testTypeNotExist(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', 'InvalidType');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@typeIsRequired');
    }

    public function testTitleIsRequired(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', $this->validateData['type']->name);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@titleIsRequired');
    }

    public function testTitleMaxLength(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', $this->validateData['type']->name);
        $this->browser->addRequestData('title', 'PEhssogFEJDvDKFsuyQytFFcvrpEFPWVHddAdemmWTbkNMpjSkMjjbk');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxTitleLength');
    }

    public function testDescriptionIsRequired(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', $this->validateData['type']->name);
        $this->browser->addRequestData('title', $this->validateData['title']);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@descriptionIsRequired');
    }

    public function testDescriptionMaxLength(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', $this->validateData['type']->name);
        $this->browser->addRequestData('title', $this->validateData['title']);
        $this->browser->addRequestData('description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxDescriptionLength');
    }

    public function testImageIsRequired(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', $this->validateData['type']->name);
        $this->browser->addRequestData('title', $this->validateData['title']);
        $this->browser->addRequestData('description', $this->validateData['description']);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@imageIsRequired');
    }

    public function testAllowedMimeTypeImage(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', $this->validateData['type']->name);
        $this->browser->addRequestData('title', $this->validateData['title']);
        $this->browser->addRequestData('description', $this->validateData['description']);
        $this->browser->addFile('image', $this->getFilePathFromFixture('text_2.5mb.txt'));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@uploadFileNotImage');
    }

    public function testMaxSizeImage(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', $this->validateData['type']->name);
        $this->browser->addRequestData('title', $this->validateData['title']);
        $this->browser->addRequestData('description', $this->validateData['description']);
        $this->browser->addFile('image', $this->getFilePathFromFixture('image_18mb.png'));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxSizeImage');
    }

    public function testOnlyOneImage(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', $this->validateData['type']->name);
        $this->browser->addRequestData('title', $this->validateData['title']);
        $this->browser->addRequestData('description', $this->validateData['description']);
        $this->browser->addMultipleFile(
            'image',
            $this->getFilePathFromFixture('image_1.3mb.jpg'),
            $this->getFilePathFromFixture('image_2mb.png')
        );
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@onlyOneImage');
    }

    public function testSuccessUpdate(): void
    {
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->updateAlbum($authorizedUserSession, $album);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::UPDATE);
        $this->assertApiMessage('Альбом успешно обновлен');
    }

    /**
     * @depends testSuccessUpdate
     */
    public function testSuccessFlushToDb(): void
    {
        $albumRepository = $this->em()->getRepository(Album::class);
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $album = $this->createAlbum($authorizedUserSession);

        $this->updateAlbum($authorizedUserSession, $album);

        $this->em()->clear();

        $updatedAlbum = $albumRepository->find($album);

        $this->assertEquals($this->validateData['type']->name, $updatedAlbum->getType()->getKey());
        $this->assertEquals($this->validateData['title'], $updatedAlbum->getTitle());
        $this->assertEquals($this->validateData['description'], $updatedAlbum->getDescription());
        $this->assertStringEndsWith('.png', $updatedAlbum->getImage());
    }

    /**
     * @depends testSuccessUpdate
     */
    public function testSuccessUpdateImageToS3(): void
    {
        $imageUploader = $this->getService(ImageUploader::class);
        $albumRepository = $this->em()->getRepository(Album::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbum = $this->createAlbum($authorizedUser);

        $this->updateAlbum($authorizedUser, $createdAlbum);

        $this->em()->clear();

        $updatedAlbum = $albumRepository->find($createdAlbum->getId());

        $this->assertNull($imageUploader->getObject($createdAlbum->getImage())); // The old image should be removed from S3
        $this->assertNotNull($imageUploader->getObject($updatedAlbum->getImage())); // The new image should be saved in S3
    }

    private function updateAlbum(UserSession $authorizedUserSession, Album $album): void
    {
        $this->browser->createRequest(self::API_PATH, ['id' => $album->getId()]);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', $this->validateData['type']->name);
        $this->browser->addRequestData('title', $this->validateData['title']);
        $this->browser->addRequestData('description', $this->validateData['description']);
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validateData['image']));
        $this->browser->sendRequest();
    }
}