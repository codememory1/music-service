<?php

namespace App\Tests\Application\PublicAvailable\Album\Update;

use App\Entity\Album;
use App\Enum\AlbumTypeEnum;
use App\Enum\ResponseTypeEnum;
use App\Rest\S3\Uploader\ImageUploader;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseRequestTrait;
use Symfony\Component\HttpFoundation\Request;

final class UpdateTest extends AbstractApiTestCase
{
    use BaseRequestTrait;
    public const API_PATH = '/api/ru/public/album/{id}/edit';
    private array $validateData = [
        'type' => AlbumTypeEnum::DOUBLE,
        'title' => 'Battle grounds edit',
        'description' => 'Edited album description',
        'image' => 'image_2mb.png'
    ];

    protected function setUp(): void
    {
        $authorizedUserSession = $this->authorize('artist@gmail.com');
        $album = $this->createAlbum($authorizedUserSession);
        $albumSecond = $this->createAlbum($this->authorize('artist2@gmail.com'));

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->prepareRequestData('type', $this->validateData['type']->name);
        $this->browser->prepareRequestData('title', $this->validateData['title']);
        $this->browser->prepareRequestData('description', $this->validateData['description']);
        $this->browser->addReference('album', $album);
        $this->browser->addReference('albumNotBelongAuthorizedUserSession', $albumSecond);
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
        $this->browser->addParameter('id', $this->browser->getReference('albumNotBelongAuthorizedUserSession')->getId());
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    public function testTypeIsRequired(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@typeIsRequired');
    }

    public function testTypeNotExist(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->addRequestData('type', 'InvalidType');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@typeIsRequired');
    }

    public function testTitleIsRequired(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->usePreparedRequestData('type');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@titleIsRequired');
    }

    public function testTitleMaxLength(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->usePreparedRequestData('type');
        $this->browser->addRequestData('title', 'PEhssogFEJDvDKFsuyQytFFcvrpEFPWVHddAdemmWTbkNMpjSkMjjbk');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxTitleLength');
    }

    public function testDescriptionIsRequired(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@descriptionIsRequired');
    }

    public function testDescriptionMaxLength(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->addRequestData('description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxDescriptionLength');
    }

    public function testImageIsRequired(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->usePreparedRequestData('description');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@imageIsRequired');
    }

    public function testAllowedMimeTypeImage(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->usePreparedRequestData('description');
        $this->browser->addFile('image', $this->getFilePathFromFixture('text_2.5mb.txt'));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@uploadFileNotImage');
    }

    public function testMaxSizeImage(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->usePreparedRequestData('description');
        $this->browser->addFile('image', $this->getFilePathFromFixture('image_18mb.png'));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxSizeImage');
    }

    public function testOnlyOneImage(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->usePreparedRequestData('description');
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
        $this->updateAlbum();

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

        $this->updateAlbum();

        $this->em()->clear();

        $updatedAlbum = $albumRepository->find($this->browser->getReference('album')->getId());

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
        $createdAlbum = $this->browser->getReference('album');

        $this->updateAlbum();

        $this->em()->clear();

        $updatedAlbum = $albumRepository->find($createdAlbum->getId());

        $this->assertNull($imageUploader->getObject($createdAlbum->getImage())); // The old image should be removed from S3
        $this->assertNotNull($imageUploader->getObject($updatedAlbum->getImage())); // The new image should be saved in S3
    }

    private function updateAlbum(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('album')->getId());
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->usePreparedRequestData('description');
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validateData['image']));
        $this->browser->sendRequest();
    }
}